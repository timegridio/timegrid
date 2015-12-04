<?php

namespace App\Http\Controllers\Manager;

use App\Models\Business;
use App\Http\Controllers\Controller;

class BusinessAgendaController extends Controller
{
    /**
     * get Index
     *
     * @param  Business $business Business to get agenda
     * @return Response           Rendered view of Business agenda
     */
    public function getIndex(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s", $business->id));

        ///////////////////////////////
        // TODO: AUTH GATE GOES HERE //
        ///////////////////////////////

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $appointments = $business->bookings()->with('contact')
                                             ->with('business')
                                             ->with('service')
                                             ->unserved()
                                             ->orderBy('start_at')
                                             ->get();
        return view('manager.businesses.appointments.'.$business->strategy.'.index', compact('business', 'appointments'));
    }
}
