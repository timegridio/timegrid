<?php

namespace App\Handlers\Events;

use App\Events\NewRegisteredContact;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LinkContactToExistingUser
{
    /**
     * Handle the event.
     *
     * @param  NewRegisteredUser  $event
     * @return void
     */
    public function handle(NewRegisteredContact $event)
    {
        logger()->info("Handle NewRegisteredUser.LinkContactToExistingUser(): ".
                       "Linking <{$event->contact->email}> to user");
        $event->contact->autolinkToUser();
    }
}
