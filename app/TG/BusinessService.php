<?php

namespace App\TG;

use App\Exceptions\BusinessAlreadyRegistered;
use App\Models\User;
use App\TG\Business\Setup\SetupStaff;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Category;

/*******************************************************************************
 * Business Service Layer
 *     High level business manager
 ******************************************************************************/
class BusinessService
{
    private $setupStaffClass = SetupStaff::class;

    /**
     * register Business.
     *
     * @param User  $user
     * @param array $data
     * @param int   $category
     *
     * @return Timegridio\Concierge\Models\Business
     */
    public function register(User $user, $data, $category)
    {
        $slug = str_slug($data['name']);

        if ($business = self::getExisting($user, $slug)) {
            return $business;
        }

        $business = new Business($data);

        $category = Category::find($category);
        $business->strategy = $category->strategy;
        $business->category()->associate($category);

        $business->save();

        auth()->user()->businesses()->attach($business);

        return $business;
    }

    /**
     * get existing registered business.
     *
     * @param User   $user User who attempts to register the business
     * @param string $slug Desired slug for business
     *
     * @throws BusinessAlreadyExists When Business exists and is not owned by User
     *
     * @return Business|false Business if found or false otherwise
     */
    public function getExisting(User $user, $slug)
    {
        $business = Business::withTrashed()->where(['slug' => $slug])->first();

        if ($business === null) {
            return false;
        }

        logger()->info("Found existing businessId:{$business->id}");

        if (!$user->isOwner($business->id)) {
            logger()->info("Already taken businessId:{$business->id}");
            throw new BusinessAlreadyRegistered();
        }

        logger()->info("Restoring owned businessId:{$business->id}");

        $business->restore();

        return $business;
    }

    /**
     * Soft delete the business.
     *
     * @param Business $business
     *
     * @throws \Exception
     *
     * @return bool|null
     */
    public function deactivate(Business $business)
    {
        return $business->delete();
    }

    /**
     * Update business attirbutes.
     *
     * @param Business $business
     * @param array    $data
     *
     * @return Timegridio\Concierge\Models\Business
     */
    public function update(Business $business, $data)
    {
        $business->where(['id' => $business->id])->update($data);

        return $business;
    }

    /**
     * Set category to a Business and save.
     *
     * @param Business $business
     * @param int      $category
     *
     * @return Timegridio\Concierge\Models\Business
     */
    public function setCategory(Business $business, $category)
    {
        $category = Category::find($category);
        $business->category()->associate($category);
        $business->save();

        return $business;
    }

    public function setup(Business $business)
    {
        $setupStaff = $this->setupStaffClass;

        $setupStaff::createStaffMember($business);
    }
}
