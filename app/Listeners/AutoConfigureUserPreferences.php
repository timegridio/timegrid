<?php

namespace App\Listeners;

use App\Events\NewUserWasRegistered;
use App\Models\User;
use App\Services\DetectTimezone;

class AutoConfigureUserPreferences
{
    private $detectTimezone;

    public function __construct(DetectTimezone $detectTimezone)
    {
        $this->detectTimezone = $detectTimezone;
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
        $timezone = $this->detectTimezone->get();

        $user->pref('timezone', $timezone);
    }
}
