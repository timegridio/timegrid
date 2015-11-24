<?php

/**
 * ToDo: To be refactored
 */

namespace App;

use App\BookingStrategyInterface;
use App\Appointment;
use App\Business;
use Carbon\Carbon;

class BookingDateslotStrategy implements BookingStrategyInterface
{
    public function generateAppointment(User $issuer, Business $business, Contact $contact, Service $service, Carbon $date)
    {
        $appointment = new Appointment();
        $appointment->doReserve();
        $appointment->setStartAtAttribute($date);
        $appointment->business()->associate($business);
        $appointment->issuer()->associate($issuer);
        $appointment->contact()->associate($contact);
        $appointment->service()->associate($service);

        return $appointment;
    }
}
