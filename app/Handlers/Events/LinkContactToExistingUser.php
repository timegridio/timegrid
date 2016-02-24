<?php

namespace App\Handlers\Events;

use App\Events\NewContactWasRegistered;
use App\Models\User;
use Timegridio\Concierge\Models\Contact;

class LinkContactToExistingUser
{
    /**
     * Handle the event.
     *
     * @param NewUserWasRegistered $event
     *
     * @return void
     */
    public function handle(NewContactWasRegistered $event)
    {
        logger()->info(__METHOD__);
        logger()->info("Linking <{$event->contact->email}> to user");

        $this->linkContactToUser($event->contact);
    }

    protected function linkContactToUser(Contact $contact)
    {
        if ($contact->email === null) {
            return $this;
        }

        $user = User::where(['email' => $contact->email])->first();

        if ($user === null) {
            $contact->user()->dissociate();
            $contact->save();

            return $this;
        }

        $contact->user()->associate($user);
        $contact->save();

        return $this;
    }
}
