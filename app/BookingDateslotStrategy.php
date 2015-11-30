<?php

/**
 * ToDo: To be refactored
 */

namespace App;

use App\Business;
use Carbon\Carbon;
use App\Appointment;
use App\BookingStrategyInterface;

class BookingDateslotStrategy implements BookingStrategyInterface
{
    public function generateAppointment(User $issuer, Business $business, Contact $contact, Service $service, Carbon $datetime, $comments = null)
    {
        $appointment = new Appointment();
        $appointment->doReserve();
        $appointment->setStartAtAttribute($datetime);
        $appointment->business()->associate($business);
        $appointment->issuer()->associate($issuer);
        $appointment->contact()->associate($contact);
        $appointment->service()->associate($service);
        $appointment->comments = $comments;
        $appointment->doHash();

        return $appointment;
    }
}
