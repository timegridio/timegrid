<?php

namespace App;

interface BookingStrategyInterface
{
    public function makeReservation(User $issuer, Business $business, $data);
}
