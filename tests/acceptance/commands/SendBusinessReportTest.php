<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Appointment;

class SendBusinessReportTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_sends_business_report()
    {
        $this->arrangeFixture();

        $exitCode = Artisan::call('business:report');

        $resultAsText = Artisan::output();

        $this->assertEquals(0, $exitCode);
        $this->assertContains('Scanning all businesses...', $resultAsText);
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

        $appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'status' => Appointment::STATUS_CONFIRMED,
            ]);
    }
}
