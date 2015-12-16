<?php

namespace App;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;

class BookingDateslotStrategy implements BookingStrategyInterface
{
    public function generateAppointment(
        User $issuer,
        Business $business,
        Contact $contact,
        Service $service,
        Carbon $datetime,
        $comments = null
    ) {
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

    public function hasRoom(Appointment $appointment, Vacancy $vacancy)
    {
        return $vacancy->hasRoom();
    }
}
