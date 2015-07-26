<?php

namespace App;

use Carbon\Carbon;
use App\BookingStrategyTimeslot;
use App\BookingStrategyDateslot;

class BookingStrategy
{
    private $strategy = null;

    public function __construct($strategyId)
    {
        switch ($strategyId) {
            case 'timeslot': $this->strategy = new BookingStrategyTimeslot(); break;
            case 'dateslot': $this->strategy = new BookingStrategyDateslot(); break;
        }
    }

    public function makeReservation(User $issuer, Business $business, $data)
    {
        return $this->strategy->makeReservation($issuer, $business, $data);
    }
}

interface BookingStrategyInterface
{
    public function makeReservation(User $issuer, Business $business, $data);
}
