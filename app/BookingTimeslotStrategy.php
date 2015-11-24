<?php

/**
 * ToDo: Work in progress
 */

namespace App;

use App\BookingStrategyInterface;
use App\Appointment;
use App\Business;
use Carbon\Carbon;

class BookingTimeslotStrategy implements BookingStrategyInterface
{
    public function generateAppointment(User $issuer, Business $business, Contact $contact, Service $service, Carbon $date)
    {
        /* ToDo */
    }
}
