<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Vacancy;
use App\Models\Business;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VacancyUnitTest extends TestCase
{
    use DatabaseTransactions;

    protected $business;

    /**
     * @covers  \App\Models\Vacancy::isHoldingAnyFor
     * @test
     */
    public function it_verifies_a_vacancy_holds_appointment_for_a_user()
    {
        /* Setup Stubs */
        $issuer = factory(User::class)->create();
        
        $business = factory(Business::class)->create();
        $business->owners()->save($issuer);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        $vacancy = factory(Vacancy::class)->make();
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);

        $contact = factory(Contact::class)->create();
        $contact->user()->associate($issuer);
        $contact->save();
        $business->contacts()->save($contact);

        $appointment = factory(Appointment::class)->make();
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->contact()->associate($contact);
        $appointment->vacancy()->associate($vacancy);
        $appointment->save();

        /* Perform Test */
        $this->assertTrue($vacancy->isHoldingAnyFor($issuer));
    }

    /**
     * @covers            \App\Models\Vacancy::isHoldingAnyFor
     * @test
     */
    public function it_verifies_a_vacancy_doesnt_hold_appointment_for_a_user()
    {
        /* Setup Stubs */
        $issuer = factory(User::class)->create();
        
        $business = factory(Business::class)->create();
        $business->owners()->save($issuer);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        $vacancy = factory(Vacancy::class)->make();
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);

        $contact = factory(Contact::class)->create();
        $business->contacts()->save($contact);

        $appointment = factory(Appointment::class)->make();
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->contact()->associate($contact);
        $appointment->vacancy()->associate($vacancy);
        $appointment->save();

        /* Perform Test */
        $this->assertFalse($vacancy->isHoldingAnyFor($issuer));
    }
}
