<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Log;
use App\Business;

class BusinessAgendaController extends Controller
{
    public function getIndex(Business $business)
    {
        $appointments = $business->bookings()->unserved()->orderBy('start_at')->get();
        return view('manager.businesses.appointments.'.$business->strategy.'.index', compact('business', 'appointments'));
    }
}
