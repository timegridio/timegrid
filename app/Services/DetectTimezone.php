<?php

namespace App\Services;

use Torann\GeoIP\GeoIP;

class DetectTimezone
{
    private $geoip;

    private $timezone = null;

    public function __construct(GeoIP $geoip)
    {
        $this->geoip = $geoip;

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
