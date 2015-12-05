<?php

namespace App;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Business;
use App\BookingTimeslotStrategy;
use App\BookingDateslotStrategy;

class BookingStrategy
{
    protected $strategy = null;

    public function __construct($strategyId)
    {
        info("BookingStrategy: Using {$strategyId}");
        switch ($strategyId) {
            case 'timeslot':
                $this->strategy = new BookingTimeslotStrategy();
                break;
            case 'dateslot':
                $this->strategy = new BookingDateslotStrategy();
                break;
            default:
                logger("BookingStrategy: __construct: Illegal strategy:{$strategyId}");
                break;
        }
    }

    public function generateAppointment(
        User $issuer,
        Business $business,
        Contact $contact,
        Service $service,
        Carbon $datetime,
        $comments = null)
    {
        return $this->strategy->generateAppointment($issuer, $business, $contact, $service, $datetime, $comments);
    }
}
