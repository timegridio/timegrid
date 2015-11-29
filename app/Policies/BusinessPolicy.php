<?php

namespace App\Policies;

use App\User;
use App\Business;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
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
     * Determine if the given business can be shown to the user.
     *
     * @param  \App\User  $user
     * @param  \App\Business  $business
     * @return bool
     */
    public function show(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given business can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Business  $business
     * @return bool
     */
    public function update(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given business can be destroyed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Business  $business
     * @return bool
     */
    public function destroy(User $user, Business $business)
    {
        return $user->isOwner($business);
    }
}
