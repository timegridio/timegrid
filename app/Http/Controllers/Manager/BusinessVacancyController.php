<?php

/**
 * ToDo: Refactor with service layers
 */

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AvailabilityServiceLayer;
use App\Business;
use App\Vacancy;
use Redirect;
use Flash;
use Carbon\Carbon;

class BusinessVacancyController extends Controller
{
    /**
     * TODO: This should probably not be a resource Controller
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Business $business)
    {
        $this->log->info("BusinessServiceController: create: businessId:{$business->id}");

        $dates = AvailabilityServiceLayer::generateAvailability($business->vacancies);
        $services = $business->services;
        if ($services->isEmpty()) {
            return view('manager.businesses.vacancies.edit', compact('business', 'dates', 'services'))
                ->withErrors(array("msg" => trans('manager.vacancies.msg.edit.no_services') ));
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
        $this->log->info("BusinessServiceController: store: businessId:{$business->id}");
        $dates = $request->get('vacancy');
        $success = false;
        foreach ($dates as $date => $vacancy) {
            foreach ($vacancy as $serviceId => $capacity) {
                switch (trim($capacity)) {
                    case '':
                        // Dont update, leave as is
                        $this->log->info("BusinessServiceController: store: [ADVICE] Blank vacancy capacity value businessId:{$business->id}");
                    break;
                    default:
                        $start_at  = Carbon::parse($date . ' ' . $business->pref('start_at'))->timezone($business->timezone);
                        $finish_at = Carbon::parse($date . ' 20:00:00')->timezone($business->timezone);

                        $vacancy = Vacancy::updateOrCreate(['business_id' => $business->id,
                                                            'service_id' => $serviceId,
                                                            'date' => $date],
                                                           ['capacity' => intval($capacity),
                                                            'start_at' => $start_at,
                                                            'finish_at' => $finish_at]
                                                          );
                        $success = true;
                    break;
                }
            }
        }
        if ($success) {
            Flash::success(trans('manager.vacancies.msg.store.success'));
            return redirect()->route('manager.business.show', [$business]);
        }
        $this->log->info("BusinessServiceController: store: [ADVICE] Nothing to update businessId:{$business->id}");
        Flash::warning(trans('manager.vacancies.msg.store.nothing_changed'));
        return redirect()->back();
    }
}
