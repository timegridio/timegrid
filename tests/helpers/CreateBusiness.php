<?php

use Timegridio\Concierge\Models\Business;
use App\Models\User;

trait CreateBusiness
{
    private function createBusiness($overrides = [])
    {
        return factory(Business::class)->create($overrides);
    }

    private function createBusinesses($quantity = 2, $overrides = [])
    {
        return factory(Business::class, $quantity)->create($overrides);
    }

    private function makeBusiness(User $owner, $overrides = [])
    {
        $business = factory(Business::class)->make($overrides);
        $business->save();
        $business->owners()->attach($owner);

        return $business;
    }
}
