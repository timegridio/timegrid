<?php

use App\Models\Domain;
use App\Models\User;

trait CreateDomain
{
    private function createDomain($overrides = [])
    {
        return factory(Domain::class)->create($overrides);
    }

    private function createDomains($quantity = 2, $overrides = [])
    {
        return factory(Domain::class, $quantity)->create($overrides);
    }

    private function makeDomain(User $owner, $overrides = [])
    {
        $domain = factory(Domain::class)->make($overrides);
        $domain->save();
        $domain->owners()->attach($owner);

        return $domain;
    }
}
