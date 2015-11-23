<?php

use App\Business;
use App\Service;
use App\Vacancy;
use App\ConciergeServiceLayer;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConciergeServiceLayerUnitTest extends TestCase
{
    use DatabaseTransactions;

    protected $business;

    /**
     * Test get vacancies from Concierge Service Layer
     * @covers            \App\ConciergeServiceLayer::getVacancies
     * @return bool Vacancy found
     */
    public function testConciergeGetVacancies()
    {
        /* Setup Stubs */
        $business = factory(Business::class)->create();
        $service = factory(Service::class)->make();
        $business->services()->save($service);
        $vacancy = factory(Vacancy::class)->make();
        $vacancy->business()->associate($business);
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);

        /* Perform Test */
        $concierge = new ConciergeServiceLayer();

        $vacancies = $concierge->getVacancies($business);
        return $this->assertContainsOnly($vacancy, $vacancies[$vacancy->date]);
    }

    /**
     * Test get empty vacancies from Concierge Service Layer
     * @covers            \App\ConciergeServiceLayer::getVacancies
     * @return void
     */
    public function testConciergeGetEmptyVacancies()
    {
        /* Setup Stubs */
        $business = factory(Business::class)->create();
        $service = factory(Service::class)->make();
        $business->services()->save($service);

        /* Perform Test */
        $concierge = new ConciergeServiceLayer();

        $vacancies = $concierge->getVacancies($business);
        foreach ($vacancies as $vacancy) {
            $this->assertContainsOnly([], $vacancy);
        }
    }
}
