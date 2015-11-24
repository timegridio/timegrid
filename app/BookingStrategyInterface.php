<?php

namespace App;

use Carbon\Carbon;

interface BookingStrategyInterface
{
    public function generateAppointment(User $issuer, Business $business, Contact $contact, Service $service, Carbon $date);
}
