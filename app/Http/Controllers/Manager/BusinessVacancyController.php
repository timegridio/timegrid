<?php

namespace App\Http\Controllers\Manager;

use Flash;
use Carbon\Carbon;
use App\Models\Vacancy;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\VacancyService;
use App\Http\Controllers\Controller;

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
        $this->log->info(sprintf("  businessId:%s", $business->id));

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
        $this->log->info(sprintf("  businessId:%s", $business->id));

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
                        $this->log->info("  Blank vacancy capacity value");
                        break;
                    default:
                        $start_at  = Carbon::parse($date.' '.$business->pref('start_at'))->timezone($business->timezone);
                        $finish_at = Carbon::parse($date.' '.$business->pref('finish_at', '20:00:00'))->timezone($business->timezone);

                        $vacancy = Vacancy::updateOrCreate([
                            'business_id' => $business->id,
                            'service_id' => $serviceId,
                            'date' => $date],
                            ['capacity' => intval($capacity),
                            'start_at' => $start_at,
                            'finish_at' => $finish_at
                            ]);
                        $changed = true;
                        break;
                }
            }
        }

        if (!$changed) {
            $this->log->warning("  Nothing to update");
            Flash::warning(trans('manager.vacancies.msg.store.nothing_changed'));
            return redirect()->back();
        }

        Flash::success(trans('manager.vacancies.msg.store.success'));
        return redirect()->route('manager.business.show', [$business]);
    }
}
