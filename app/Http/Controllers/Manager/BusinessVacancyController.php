<?php

namespace App\Http\Controllers\Manager;

use Flash;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\VacancyService;
use App\Http\Controllers\Controller;

class BusinessVacancyController extends Controller
{
    /**
     * [$vacancyService description]
     *
     * @var [type]
     */
    private $vacancyService;

    /**
     * [__construct description]
     *
     * @param VacancyService $vacancyService [description]
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

        $dates = $this->vacancyService->generateAvailability($business->vacancies);

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

        $vacanciesForPublishing = $request->get('vacancy');

        if (!$this->vacancyService->update($business, $vacanciesForPublishing)) {
            $this->log->warning('Nothing to update');
            
            Flash::warning(trans('manager.vacancies.msg.store.nothing_changed'));
            return redirect()->back();
        }

        $this->log->info('Vacancies updated');
        
        Flash::success(trans('manager.vacancies.msg.store.success'));
        return redirect()->route('manager.business.show', [$business]);
    }
}
