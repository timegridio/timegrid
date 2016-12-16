<?php

namespace App\Policies;

use Timegridio\Concierge\Models\Business;
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
     * Determine if the given business can be updated by the user.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function update(User $user, Business $business)
    {
        return $user->isOwnerOf($business);
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
        return $user->isOwnerOf($business);
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
        return $user->isOwnerOf($business);
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
        return $user->isOwnerOf($business);
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
        return $user->isOwnerOf($business);
    }

    /**
     * Determine if the given user can manage a business' human resources.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function manageHumanresources(User $user, Business $business)
    {
        return $user->isOwnerOf($business);
    }

    /**
     * Determine if the given user can manage a business' service.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function manageServices(User $user, Business $business)
    {
        return $user->isOwnerOf($business);
    }

    /**
     * Determine if the given user can manage a business' vacancies.
     *
     * @param User     $user
     * @param Business $business
     *
     * @return bool
     */
    public function manageVacancies(User $user, Business $business)
    {
        return $user->isOwnerOf($business);
    }
}
