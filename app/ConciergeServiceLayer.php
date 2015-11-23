<?php

namespace App;

use App\VacancyFacade;
use App\Business;

class ConciergeServiceLayer
{
    public function getVacancies(Business $business)
    {
        $vacancyFacade = new VacancyFacade($business);

        return $vacancyFacade->getVacancies();
    }
}
