<?php

namespace App;

use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

interface BookingStrategyInterface
{
    public function generateAppointment(
        User $issuer,
        Business $business,
        Contact $contact,
        Service $service,
        Carbon $datetime,
        $comments = null
    );
}
