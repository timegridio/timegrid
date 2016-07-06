<?php

namespace App\Services;

use Carbon\Carbon;

class ICalChecker
{
    private $icalevents;

    public function __construct()
    {
        $this->icalevents = app()->make('ical');
    }

    public function loadString($contents)
    {
        $this->icalevents->loadString($contents);
    }

    public function isBusy(Carbon $atDateTime)
    {
        return $this->icalevents->isBusy($atDateTime);
    }

    public function all()
    {
        return $this->icalevents->get()->all();
    }
}
