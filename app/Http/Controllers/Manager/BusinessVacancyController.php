<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Services\VacancyService;
use Flash;
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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN
        $daysQuantity = $business->pref('vacancy_edit_days_quantity', env('DEFAULT_VACANCY_EDIT_DAYS_QUANTITY', 15));

        $dates = $this->vacancyService->generateAvailability($business->vacancies, 'today', $daysQuantity);

        if ($business->services->isEmpty()) {
            Flash::warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        return view('manager.businesses.vacancies.edit', compact('business', 'dates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Business $business, Request $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageVacancies', $business);

        // BEGIN

        $publishedVacancies = $request->get('vacancy');

        if (!$this->vacancyService->update($business, $publishedVacancies)) {
            $this->log->warning('Nothing to update');

            Flash::warning(trans('manager.vacancies.msg.store.nothing_changed'));

            return redirect()->back();
        }

        $this->log->info('Vacancies updated');

        Flash::success(trans('manager.vacancies.msg.store.success'));

        return redirect()->route('manager.business.show', [$business]);
    }
}
