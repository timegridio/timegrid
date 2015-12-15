<?php

namespace App\Handlers\Events;

use App\Events\NewContactWasRegistered;

class LinkContactToExistingUser
{
    /**
     * Handle the event.
     *
     * @param NewRegisteredUser $event
     *
     * @return void
     */
    public function handle(NewContactWasRegistered $event)
    {
        logger()->info(__METHOD__);
        logger()->info("Linking <{$event->contact->email}> to user");

        $event->contact->autolinkToUser();
    }
}
