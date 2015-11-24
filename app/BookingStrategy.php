<?php

namespace App;

use Carbon\Carbon;
use App\BookingTimeslotStrategy;
use App\BookingDateslotStrategy;

class BookingStrategy
{
    protected $log;

    protected $strategy = null;

    public function __construct($strategyId)
    {
        $this->log = app()->make('log');

        $this->log->info("BookingStrategy: Using {$strategyId}");
        switch ($strategyId) {
            case 'timeslot':
                $this->strategy = new BookingTimeslotStrategy();
            break;
            case 'dateslot':
                $this->strategy = new BookingDateslotStrategy();
            break;
            default:
                $this->log->warning("BookingStrategy: __construct: Illegal strategy:{$strategyId}");
            break;
        }
    }

    public function generateAppointment(User $issuer, Business $business, Contact $contact, Service $service, Carbon $date)
    {
        return $this->strategy->generateAppointment($issuer, $business, $contact, $service, $date);
    }
}
