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

    public function makeReservation(Business $business, $data)
    {
        return $this->strategy->makeReservation($business, $data);
    }
}

interface BookingStrategyInterface
{
    public function makeReservation(Business $business, $data);
}
