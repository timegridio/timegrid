<?php

use App\Business;
use App\ConciergeServiceLayer;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConciergeServiceLayerUnitTest extends TestCase
{
    use DatabaseTransactions;

    /* ToDo: Work in progress here
        Need to mock several Businesses with vacancies set
    */
    public function testConciergeGetVacancies()
    {
        $concierge = new ConciergeServiceLayer();

        return $concierge->getVacancies(new Business());
    }
}
