<?php

namespace App;

use App\VacancyChecker;
use App\Business;

class ConciergeServiceLayer
{
    public function getVacancies(Business $business)
    {
        $vacancyChecker = new VacancyChecker($business);

        return $vacancyChecker->getVacancies();
    }
}
