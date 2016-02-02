<?php

namespace App\Handlers\Events;

use App\Events\NewContactWasRegistered;
use App\Models\User;

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

        $this->linkToUser($event->contact);
    }

    /**
     * link Contact to existing User if any.
     *
     * @return Contact Current Contact linked to user
     */
    protected function linkToUser($contact)
    {
        if ($contact->email === null) {
            return $contact;
        }

        $user = User::where(['email' => $contact->email])->first();

        if ($user === null) {
            $contact->user()->dissociate();
            $contact->save();

            return $contact;
        }

        $contact->user()->associate($user);
        $contact->save();

        return $contact;
    }
}
