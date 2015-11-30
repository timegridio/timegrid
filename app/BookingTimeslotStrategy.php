<?php

/**
 * ToDo: Work in progress
 */

namespace App;

use App\Business;
use Carbon\Carbon;
use App\Appointment;
use App\BookingStrategyInterface;

class BookingTimeslotStrategy implements BookingStrategyInterface
{
    public function generateAppointment(User $issuer, Business $business, Contact $contact, Service $service, Carbon $datetime, $comments = null)
    {
        /* ToDo */
    }
}
