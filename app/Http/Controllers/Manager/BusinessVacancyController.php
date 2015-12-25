<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Services\VacancyParserService;
use App\Services\VacancyService;
use Illuminate\Http\Request;

class BusinessVacancyController extends Controller
{
    /**
     * Vacancy service implementation.
     *
     * @var App\Services\VacancyService
     */
    private $vacancyService;

    /**
     * Create controller.
     *
     * @param App\Services\VacancyService $vacancyService
     */
    public function __construct(VacancyService $vacancyService)
    {
        $this->vacancyService = $vacancyService;

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
        $daysQuantity = $business->pref('vacancy_edit_days_quantity', env('DEFAULT_VACANCY_EDIT_DAYS_QUANTITY', 15));

        $dates = $this->vacancyService->generateAvailability($business->vacancies, 'today', $daysQuantity);

        if ($business->services->isEmpty()) {
            flash()->warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        $advanced = true;

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

        $publishedVacancies = $request->get('vacancy');

        if (!$this->vacancyService->update($business, $publishedVacancies)) {
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
     * @param  Business $business
     * @param  Request  $request
     *
     * @return Illuminate\Http\Response
     */
    public function storeBatch(Business $business, Request $request, VacancyParserService $vacancyParser)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN
        $publishedVacancies = $vacancyParser->parseStatements($request->input('vacancies'));

        if (!$this->vacancyService->updateBatch($business, $publishedVacancies)) {
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
        $daysQuantity = $business->pref('vacancy_edit_days_quantity', env('DEFAULT_VACANCY_EDIT_DAYS_QUANTITY', 7));

        $vacancies = $business->vacancies()->with('Appointments')->get();

        $timetable = $this->vacancyService
                          ->setBusiness($business)
                          ->buildTimetable($vacancies, 'today', $daysQuantity);

        if ($business->services->isEmpty()) {
            flash()->warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        return view('manager.businesses.vacancies.show', compact('business', 'timetable'));
    }
}
