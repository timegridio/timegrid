<?php

namespace App\Listeners;

use App\Events\NewUserWasRegistered;
use App\Models\User;
use Torann\GeoIP\GeoIP;

class AutoConfigureUserPreferences
{
    private $geoip;

    public function __construct(GeoIP $geoip)
    {
        $this->geoip = $geoip;
    }

    /**
     * Handle the event.
     *
     * @param NewUserWasRegistered $event
     *
     * @return void
     */
    public function handle(NewUserWasRegistered $event)
    {
        logger()->info(__CLASS__.':'.__METHOD__);

        $this->saveUserTimezone($event->user);
    }

    protected function saveUserTimezone(User $user)
    {
        $timezone = $this->detectUserTimezone();

        $user->pref('timezone', $timezone);
    }

    protected function detectUserTimezone()
    {
        $location = $this->geoip->getLocation();

        return $location['timezone'];
    }
}
