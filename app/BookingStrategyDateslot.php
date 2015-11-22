<?php

/**
 * ToDo: To be refactored
 */

namespace App;

use App\Appointment;
use App\Business;
use Carbon\Carbon;

class BookingStrategyDateslot implements BookingStrategyInterface
{
    public function makeReservation(User $issuer, Business $business, $data)
    {
        $data['issuer_id'] = $issuer->id;
        $data['business_id'] = $business->id;
        $data['start_at'] = Carbon::parse($data['_date'] . $business->pref('start_at'), $business->timezone)->timezone('UTC');
        $data['duration'] = 0;
        return new Appointment($data);
    }
}
