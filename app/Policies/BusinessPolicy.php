<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
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
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function show(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given business can be updated by the user.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function update(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given business can be destroyed by the user.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function destroy(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given business can be configured by the user.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function managePreferences(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given user can manage the business.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function manage(User $user, Business $business)
    {
        return $user->isOwner($business);
    }

    /**
     * Determine if the given user can manage a business' contact.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function manageContacts(User $user, Business $business)
    {
        return $user->isOwner($business);
    }
}
