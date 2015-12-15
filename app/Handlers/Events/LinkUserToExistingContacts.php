<?php

namespace App\Handlers\Events;

use App\Events\NewUserWasRegistered;

class LinkUserToExistingContacts
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
        logger()->info(__METHOD__);
        logger()->info("Linking <{$event->user->email}> to user");

        $event->user->linkToContacts();
    }
}
