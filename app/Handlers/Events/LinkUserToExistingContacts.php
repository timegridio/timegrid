<?php

namespace App\Handlers\Events;

use App\Events\NewRegisteredUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class LinkUserToExistingContacts
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewRegisteredUser  $event
     * @return void
     */
    public function handle(NewRegisteredUser $event)
    {
        Log::info("Handle NewRegisteredUser.LinkUserToExistingContacts(): Linking <{$event->user->email}> to contacts");
        $event->user->linkToContacts();
    }
}
