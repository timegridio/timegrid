<?php

namespace App;

use App\Appointment;
use App\Business;
use Carbon\Carbon;

class BookingStrategyDateslot implements BookingStrategyInterface
{
    public function makeReservation(Business $business, $data)
    {
        $data['business_id'] = $business->id;
        $data['start_at'] = Carbon::parse($data['_date'] . ' 08:00 AM', $business->tz)->timezone('UTC')->toDateTimeString();
        $data['duration'] = 0;
        $appointment = new Appointment($data);
        return $appointment->save();
    }
}
