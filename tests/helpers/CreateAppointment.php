<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\User;

trait CreateAppointment
{
    private function createAppointment($overrides = [])
    {
        return factory(Appointment::class)->create($overrides);
    }

    private function makeAppointment(Business $business, User $issuer, Contact $contact, $override = [])
    {
        $appointment = factory(Appointment::class)->make($override);
        $appointment->contact()->associate($contact);
        $appointment->issuer()->associate($issuer);
        $appointment->business()->associate($business);

        return $appointment;
    }
}
