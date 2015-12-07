<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

/*******************************************************************************
 * Business Service Layer
 *     High level business manager
 ******************************************************************************/
class BusinessService
{
    /**
     * register Business
     *
     * @param  User   $user     [description]
     * @param  [type] $data     [description]
     * @param  [type] $category [description]
     * @return [type]           [description]
     */
    public static function register(User $user, $data, $category)
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
     * get existing registered business
     *
     * @param  User           $user  User who attempts to register the business
     * @param  string         $slug  Desired slug for business
     * @return Business|false        Business if found or false otherwise
     * @throws BusinessAlreadyExists When Business exists and is not owned by User
     */
    public static function getExisting(User $user, $slug)
    {
        $business = Business::withTrashed()->where(['slug' => $slug])->first();

        if ($business === null) {
            return false;
        }

        logger()->info("Found existing businessId:{$business->id}");

        if (!$user->isOwner($business->id)) {
            logger()->info("Already taken businessId:{$business->id}");
            throw new BusinessAlreadyExists;
        }

        logger()->info("Restoring owned businessId:{$business->id}");
        
        $business->restore();

        return $business;
    }
}
