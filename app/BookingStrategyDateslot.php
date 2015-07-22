<?php

namespace App;

use App\Appointment;
use App\Business;
use Carbon\Carbon;

class BookingStrategyDateslot implements BookingStrategyInterface
{
    public function makeReservation(Business $business, $data)
    {
        $data['issuer_id'] = \Auth::user()->id;
        $data['business_id'] = $business->id;
        $data['start_at'] = Carbon::parse($data['_date'] . $business->pref('start_at'), $business->tz)->timezone('UTC')->toDateTimeString();
        $data['duration'] = 0;
        return new Appointment($data);
    }
}
