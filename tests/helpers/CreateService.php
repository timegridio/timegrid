<?php

use App\Models\Service;

trait CreateService
{
    private function createService($overrides = [])
    {
        return factory(Service::class)->create($overrides);
    }

    private function makeService($overrides = [])
    {
        return factory(Service::class)->make($overrides);
    }
}
