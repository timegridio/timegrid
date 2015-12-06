<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given contact can be managed by the profile owner user.
     *
     * @param User     $user
     * @param Business $business
     * @param Business $contact
     *
     * @return bool
     */
    public function manage(User $user, Contact $contact)
    {
        return $user->id == $contact->user->id;
    }
}
