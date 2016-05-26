<?php

namespace App\Handlers\Events;

use App\Events\NewUserWasRegistered;

class AutoConfigureUserPreferences
{
    /**
     * Handle the event.
     *
     * @param NewUserWasRegistered $event
     *
     * @return void
     */
    public function handle(NewUserWasRegistered $event)
    {
        logger()->info('Handle NewUserWasRegistered.AutoConfigureUserPreferences()');

        $this->saveUserTimezone($event->user);
    }

    protected function saveUserTimezone($user)
    {
        try {
            $timezone = $this->detectUserTimezone();

            $user->pref('timezone', $timezone);
        } catch (Exception $e) {
            logger()->info('User Timezone could not be retrieved');
        }
    }

    protected function detectUserTimezone()
    {
        $geoip = app('geoip');

        $location = $geoip->getLocation();

        return $location['timezone'];
    }
}
