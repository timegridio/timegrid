<?php

namespace App\TG;

class DetectTimezone
{
    private $geoip;

    private $timezone = null;

    public function __construct()
    {
        $this->geoip = app('geoip');

        $this->detect();
    }

    public function __toString()
    {
        return $this->get();
    }

    public function get()
    {
        return $this->timezone;
    }

    protected function detect()
    {
        $location = $this->geoip->getLocation();

        $this->timezone = $location['timezone'];

        return $this->timezone;
    }
}
