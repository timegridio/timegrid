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

    public function makeReservation(User $issuer, Business $business, Contact $contact, Service $service, Carbon $date)
    {
        $bookingStrategy = new BookingStrategy($business->strategy);

        $appointment = $bookingStrategy->generateAppointment($issuer, $business, $contact, $service, $date);
        
        $availabilityServiceLayer = new AvailabilityServiceLayer($business);

        if($availabilityServiceLayer->isSlotAvailable($appointment))
        {
            $appointment->save();
            return $appointment;
        }
        return false;
    }
}
