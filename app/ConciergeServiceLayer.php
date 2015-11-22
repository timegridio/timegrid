<?php

namespace App;

use Carbon\Carbon;
use App\User;
use App\Business;
use App\Contact;
use App\Service;

class ConciergeServiceLayer
{
    public static function requestBooking(User $user, Business $business, Service $service, Carbon $date)
    {
        $bookingServiceLayer = new BookingServiceLayer($business->strategy);
    }
}
