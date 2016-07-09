<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AvailabilityControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_provides_available_dates_for_requested_service()
    {
        $this->arrangeFixture();

        $this->actingAs($this->issuer);

        $this->get("api/vacancies/{$this->business->id}/{$this->service->id}");

        $this->assertResponseOk();
        $this->seeJson();
    }

    /**
     * @test
     */
    public function it_provides_available_times_for_requested_service_date()
    {
        $this->arrangeFixture();

        $this->actingAs($this->issuer);

        $this->get("api/vacancies/{$this->business->id}/{$this->service->id}/{$this->vacancy->date}");

        $this->assertResponseOk();
        $this->seeJson();
    }

    /**
     * Arrange Fixture.
     *
     * @return void
     */
    protected function arrangeFixture()
    {
        $this->owner = $this->createUser();

        $this->issuer = $this->createUser();

        $this->business = $this->createBusiness();
        $this->business->owners()->save($this->owner);

        $this->contact = $this->createContact();

        $this->contact->user()->associate($this->issuer);

        $this->service = $this->makeService();
        $this->business->services()->save($this->service);

        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);
    }
}
