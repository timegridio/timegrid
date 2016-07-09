<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JavaScript;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\HumanResource;
use Timegridio\Concierge\Models\Service;
use Timegridio\Concierge\Vacancy\VacancyParser;

class BusinessVacancyController extends Controller
{
    /**
     * Concierge.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param Timegridio\Concierge\Concierge
     */
    public function __construct(Concierge $concierge)
    {
        $this->concierge = $concierge;

        parent::__construct();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN

        JavaScript::put([
            'services'       => $business->services->pluck('slug')->all(),
            'humanresources' => $business->humanresources->pluck('slug')->all(),
        ]);

        $daysQuantity = $business->pref('vacancy_edit_days_quantity', config('root.vacancy_edit_days'));

        $dates = $this->concierge
                      ->business($business)
                      ->vacancies()
                      ->generateAvailability('today', $daysQuantity);

        if ($business->services->isEmpty()) {
            flash()->warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        $advanced = $business->services->count() > 3 || $business->pref('vacancy_edit_advanced_mode');

        $template = $this->recallStatements($business->id);
        if ($advanced && empty($template)) {
            $template = $this->concierge
                             ->vacancies()
                             ->builder()
                             ->getTemplate($business, $business->services()->first());
        }
        $servicesList = $business->services()->pluck('name', 'slug');
        $humanresourcesList = $business->humanresources()->pluck('name', 'slug');
        $weekdaysList = [
            'mon' => trans('datetime.weekday.monday'),
            'tue' => trans('datetime.weekday.tuesday'),
            'wed' => trans('datetime.weekday.wednesday'),
            'thu' => trans('datetime.weekday.thursday'),
            'fri' => trans('datetime.weekday.friday'),
            'sat' => trans('datetime.weekday.saturday'),
            'sun' => trans('datetime.weekday.sunday'),
            ];

        $startAt = $business->pref('start_at');
        $finishAt = $business->pref('finish_at');

        $viewParams = compact('business', 'dates', 'advanced', 'template', 'servicesList', 'humanresourcesList', 'weekdaysList', 'startAt', 'finishAt');

        return view('manager.businesses.vacancies.edit', $viewParams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $publishedVacancies = $request->get('vacancy');

        $changed = false;

        foreach ($publishedVacancies as $date => $vacancy) {
            foreach ($vacancy as $serviceId => $capacity) {
                $startAt = Carbon::parse($date.' '.$business->pref('start_at').' '.$business->timezone);
                $finishAt = Carbon::parse($date.' '.$business->pref('finish_at').' '.$business->timezone);

                if ($capacity === '') {
                    continue;
                }

                $changed |= true;

                $this->concierge
                     ->business($business)
                     ->vacancies()
                     ->publish($date, $startAt, $finishAt, $serviceId, $capacity);
            }
        }

        if (!$changed) {
            logger()->warning('Nothing to update');

            flash()->warning(trans('manager.vacancies.msg.store.nothing_changed'));

            return redirect()->back();
        }

        logger()->info('Vacancies updated');

        flash()->success(trans('manager.vacancies.msg.store.success'));

        return redirect()->route('manager.business.show', [$business]);
    }

    /**
     * Store vacancies from a command string.
     *
     * @param Business $business
     * @param Request  $request
     *
     * @return Illuminate\Http\Response
     */
    public function storeBatch(Business $business, Request $request, VacancyParser $vacancyParser)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $this->concierge->business($business);

        $statements = $request->input('vacancies');
        $unpublish = $request->input('unpublish');

        if ($unpublish) {
            $this->concierge->vacancies()->unpublish();
        }

        $publishedVacancies = $vacancyParser->parseStatements($statements);

        if (!$this->concierge->vacancies()->updateBatch($business, $publishedVacancies)) {
            logger()->warning('Nothing to update');

            flash()->warning(trans('manager.vacancies.msg.store.nothing_changed'));

            return redirect()->back();
        }

        if ($request->input('remember')) {
            $this->rememberStatements($business->id, $statements);
        }

        logger()->info('Vacancies updated');

        flash()->success(trans('manager.vacancies.msg.store.success'));

        return redirect()->route('manager.business.show', [$business]);
    }

    /**
     * Show the published vacancies timetable.
     *
     * @return Response
     */
    public function show(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $daysQuantity = $business->pref('vacancy_edit_days_quantity', config('root.vacancy_edit_days'));

        $vacancies = $business->vacancies()->with('Appointments')->get();

        $timetable = $this->concierge
                          ->business($business)
                          ->timetable()
                          ->buildTimetable($vacancies, 'today', $daysQuantity);

        if ($business->services->isEmpty()) {
            flash()->warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        return view('manager.businesses.vacancies.show', compact('business', 'timetable'));
    }

    public function update(Business $business, Request $request, VacancyParser $vacancyParser)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN

        $serviceId = $request->input('serviceId');
        $weekdays = $request->input('weekdays');

        logger()->info($weekdays);

        $service = $business->services()->find($serviceId);
        $humanResource = $business->humanresources()->first();

        $startAt = $business->pref('start_at');
        $finishAt = $business->pref('finish_at');

        $statements = $this->buildStatements($service, $humanResource, $weekdays, $startAt, $finishAt, $business->timezone);

        $publishedVacancies = $vacancyParser->parseStatements($statements);

        $this->concierge->business($business);

        if ($vacanciesToWipe = $business->vacancies()->where(['service_id' => $service->id])) {
            $vacanciesToWipe->delete();
        }

        if ($this->concierge->vacancies()->updateBatch($business, $publishedVacancies)) {
            logger()->info('Vacancies updated');
        }

        return response()->json(['status' => 'OK']);
    }

    protected function buildStatements(Service $service, HumanResource $humanResource, $weekdays, $startAt, $finishAt, $timezone)
    {
        $out = [];

        $out[] = "{$service->slug}:{$humanResource->slug}";
        $dates = [];
        foreach ($weekdays as $day => $status) {
            for ($i = 0; $i < 4; $i++) {
                $dates[] = Carbon::parse($day." +$i weeks ".$timezone)->toDateString();
            }
        }
        $out[] = ' '.implode(',', $dates);
        $out[] = "  {$startAt} - {$finishAt}";

        return implode("\n", $out);
    }

    protected function rememberStatements($businessId, $statements)
    {
        return Storage::put(
            $this->getStatementsFile($businessId),
            $statements
        );
    }

    protected function recallStatements($businessId)
    {
        if (!Storage::exists($this->getStatementsFile($businessId))) {
            return;
        }

        return Storage::get(
            $this->getStatementsFile($businessId)
        );
    }

    protected function getStatementsFile($businessId)
    {
        return 'business'.DIRECTORY_SEPARATOR.$businessId.DIRECTORY_SEPARATOR.'vacancy-statements.txt';
    }
}
