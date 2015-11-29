<?php

use App\User;
use App\Business;
use App\Contact;
use App\Appointment;
use App\Service;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VacancyUnitTest extends TestCase
{
    use DatabaseTransactions;

    protected $business;

    /**
     * @covers            \App\Vacancy::isHoldingAnyFor
     */
    public function testIsHoldingAnyFor()
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
     * @covers            \App\Vacancy::isHoldingAnyFor
     */
    public function testIsNotHoldingAnyFor()
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
