<?php

namespace App\Handlers\Events;

use App\Events\NewRegisteredUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LinkUserToExistingContacts
{
    /**
     * Handle the event.
     *
     * @param  NewRegisteredUser  $event
     * @return void
     */
    public function handle(NewRegisteredUser $event)
    {
        logger()->info("Handle NewRegisteredUser.LinkUserToExistingContacts(): ".
                       "Linking <{$event->user->email}> to contacts");
        $event->user->linkToContacts();
    }
}
