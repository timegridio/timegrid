<?php

/**
 * ToDo: To be refactored
 */

namespace App;

use App\Appointment;
use App\Business;
use Carbon\Carbon;

class BookingStrategyTimeslot implements BookingStrategyInterface
{
    public function makeReservation(User $issuer, Business $business, $data)
    {
        $data['business_id'] = $business->id;
        $appointment = new Appointment($data);
        return $appointment->save();
    }
}
