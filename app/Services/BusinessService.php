<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Category;
use App\Models\User;

/*******************************************************************************
 * Business Service Layer
 *     High level business manager
 ******************************************************************************/
class BusinessService
{
    /**
     * register Business.
     *
     * @param User   $user
     * @param array  $data
     * @param int    $category
     *
     * @return App\Models\Business
     */
    public function register(User $user, $data, $category)
    {
        if (false === $business = self::getExisting($user, $data['slug'])) {
            $business = new Business($data);

            $category = Category::find($category);

            $business->strategy = $category->strategy;
            $business->category()->associate($category);
            $business->save();

            auth()->user()->businesses()->attach($business);
            auth()->user()->save();
        }

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
            throw new BusinessAlreadyExists();
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
     * @return bool|null
     *
     * @throws \Exception
     */
    public function deactivate(Business $business)
    {
        return $business->delete();
    }

    /**
     * Update business attirbutes.
     * 
     * @param  Business $business
     * @param  array    $data
     * 
     * @return App\Models\Business
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
     * @return App\Models\Business
     */
    public function setCategory(Business $business, $category)
    {
        $category = Category::find($category);
        $business->category()->associate($category);
        $business->save();

        return $business;
    }
}
