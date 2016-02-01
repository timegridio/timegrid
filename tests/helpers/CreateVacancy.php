<?php

use Timegridio\Concierge\Models\Vacancy;

trait CreateVacancy
{
    private function createVacancy($overrides = [])
    {
        return factory(Vacancy::class)->create($overrides);
    }

    private function makeVacancy($override = [])
    {
        return factory(Vacancy::class)->make($override);
    }
}
