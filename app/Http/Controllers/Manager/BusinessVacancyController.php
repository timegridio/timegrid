<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Vacancy;
use App\Services\VacancyService;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;

class BusinessVacancyController extends Controller
{
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

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $dates = VacancyService::generateAvailability($business->vacancies);
        $services = $business->services;

        if ($services->isEmpty()) {
            Flash::warning(trans('manager.vacancies.msg.edit.no_services'));
        }

        return view('manager.businesses.vacancies.edit', compact('business', 'dates', 'services'));
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

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $dates = $request->get('vacancy');
        $changed = false;

        foreach ($dates as $date => $vacancy) {
            foreach ($vacancy as $serviceId => $capacity) {
                switch (trim($capacity)) {
                    case '':
                        // Dont update, leave as is
                        $this->log->info('Blank vacancy capacity value');
                        break;
                    default:
                        $startAt = Carbon::parse($date.' '.$business->pref('start_at'))
                            ->timezone($business->timezone);
                        $finishAt = Carbon::parse($date.' '.$business->pref('finish_at'))
                            ->timezone($business->timezone);

                        $vacancyKeys = [
                            'business_id' => $business->id,
                            'service_id'  => $serviceId,
                            'date'        => $date,
                            ];

                        $vacancyValues = [
                            'capacity'  => intval($capacity),
                            'start_at'  => $startAt,
                            'finish_at' => $finishAt,
                            ];

                        $vacancy = Vacancy::updateOrCreate($vacancyKeys, $vacancyValues);

                        $changed = true;
                        break;
                }
            }
        }

        if (!$changed) {
            $this->log->warning('Nothing to update');
            Flash::warning(trans('manager.vacancies.msg.store.nothing_changed'));

            return redirect()->back();
        }

        $this->log->warning('Vacancies updated');
        Flash::success(trans('manager.vacancies.msg.store.success'));

        return redirect()->route('manager.business.show', [$business]);
    }
}
