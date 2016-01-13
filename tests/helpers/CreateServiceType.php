<?php

use App\Models\ServiceType;

trait CreateServiceType
{
    private function createServiceType($overrides = [])
    {
        return factory(ServiceType::class)->create($overrides);
    }

    private function makeServiceType($overrides = [])
    {
        return factory(ServiceType::class)->make($overrides);
    }
}
