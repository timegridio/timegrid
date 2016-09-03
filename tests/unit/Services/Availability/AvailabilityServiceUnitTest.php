<?php

use App\TG\Availability;
use App\TG\Availability\AvailabilityService;

class AvailabilityServiceUnitTest extends TestCase
{
    use CreateUser, CreateBusiness, CreateService, CreateContact, CreateAppointment, CreateVacancy, ArrangeFixture;

    protected $availability;

    public function setUp()
    {
        parent::setUp();

        $this->availability = new AvailabilityService;
    }

    /**
     * @test
     */
    public function it_gets_available_dates()
    {
        $this->arrangeFixture();

        $vacancy = $this->makeVacancy();
        $vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($vacancy);

        $dates = $this->availability->getDates($this->business, $this->service->id);

        $this->assertContains($this->vacancy->date, $dates);
    }

    /**
     * @test
     */
    public function it_gets_available_dates_and_excludes_specified_dates()
    {
        $this->arrangeFixture();

        $vacancy = $this->makeVacancy();
        $vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($vacancy);

        $dates = $this->availability->excludeDates([$this->vacancy->date])
                                    ->getDates($this->business, $this->service->id);

        $this->assertNotContains($this->vacancy->date, $dates);
    }
}
