<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JavaScript;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;
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
            'services' => $business->services->pluck('slug')->all(),
        ]);

        $daysQuantity = $business->pref('vacancy_edit_days_quantity', config('root.vacancy_edit_days'));

        $dates = $this->concierge
                      ->business($business)
                      ->vacancies()
                      ->generateAvailability($business->vacancies, 'today', $daysQuantity);

        if ($business->services->isEmpty()) {
            flash()->warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        $advanced = $business->services->count() > 3 || $business->pref('vacancy_edit_advanced_mode');

        return view('manager.businesses.vacancies.edit', compact('business', 'dates', 'advanced'));
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

        $publishedVacancies = $vacancyParser->parseStatements($request->input('vacancies'));

        if (!$this->concierge->business($business)->vacancies()->updateBatch($business, $publishedVacancies)) {
            logger()->warning('Nothing to update');

            flash()->warning(trans('manager.vacancies.msg.store.nothing_changed'));

            return redirect()->back();
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
}
