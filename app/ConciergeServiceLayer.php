<?php

namespace App;

use App\AvailabilityServiceLayer;
use App\Business;
use Carbon\Carbon;

class ConciergeServiceLayer
{
    public function getVacancies(Business $business)
    {
        $availabilityServiceLayer = new AvailabilityServiceLayer($business);

        return $availabilityServiceLayer->getVacancies();
    }

    public function getAppointmentsFor(User $user)
    {
        return $user->appointments()->orderBy('start_at')->get();
    }

    public function makeReservation(User $issuer, Business $business, Contact $contact, Service $service, Carbon $date)
    {
        $bookingStrategy = new BookingStrategy($business->strategy);

        $appointment = $bookingStrategy->generateAppointment($issuer, $business, $contact, $service, $date);

        # $appointment->doHash();

        if($appointment->duplicates())
        {
            return $appointment;
        }

        $availabilityServiceLayer = new AvailabilityServiceLayer($business);

        $vacancy = $availabilityServiceLayer->getSlotFor($appointment);

        if(null !== $vacancy)
        {
            if($vacancy->hasRoom())
            {
                $appointment->vacancy()->associate($vacancy);
                $appointment->save();

                #$vacancy->appointments()->save($appointment);
                return $appointment;
            }
        }
        return false;
    }
}
