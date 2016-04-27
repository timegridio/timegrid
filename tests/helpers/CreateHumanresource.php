<?php

use Timegridio\Concierge\Models\Humanresource;

trait CreateHumanresource
{
    private function createHumanresource($overrides = [])
    {
        return factory(Humanresource::class)->create($overrides);
    }

    private function makeHumanresource($override = [])
    {
        return factory(Humanresource::class)->make($override);
    }
}
