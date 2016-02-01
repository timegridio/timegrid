<?php

use Timegridio\Concierge\Models\Contact;
use App\Models\User;

trait CreateContact
{
    private function createContact($overrides = [])
    {
        return factory(Contact::class)->create($overrides);
    }

    private function makeContact(User $user = null)
    {
        $contact = factory(Contact::class)->make();
        if ($user) {
            $contact->user()->associate($user);
        }

        return $contact;
    }
}
