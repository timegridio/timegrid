<?php

use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Vacancy;
use App\Models\Business;
use App\Models\Appointment;
use App\AvailabilityServiceLayer;
use App\Services\ConciergeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConciergeServiceUnitTest extends TestCase
{
    use DatabaseTransactions;

    protected $business;

    /**
     * Test get vacancies from Concierge Service Layer
     * @covers            \App\Services\ConciergeService::getVacancies
     * @return bool Vacancy found
     */
    public function testConciergeGetVacancies()
    {
        /* Setup Stubs */
        $user = factory(User::class)->create();

        $business = factory(Business::class)->create();
        $service = factory(Service::class)->make();
        $business->services()->save($service);
        $vacancy = factory(Vacancy::class)->make();
        $vacancy->business()->associate($business);
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);

        /* Perform Test */
        $concierge = new ConciergeService(new AvailabilityServiceLayer($business));

        $vacancies = $concierge->getVacancies($user);
        return $this->assertContainsOnly($vacancy, $vacancies[$vacancy->date]);
    }

    /**
     * Test get empty vacancies from Concierge Service Layer
     * @covers            \App\Services\ConciergeService::getVacancies
     */
    public function testConciergeGetEmptyVacancies()
    {
        /* Setup Stubs */
        $user = factory(User::class)->create();

        $business = factory(Business::class)->create();
        $service = factory(Service::class)->make();
        $business->services()->save($service);

        /* Perform Test */
        $concierge = new ConciergeService(new AvailabilityServiceLayer($business));

        $vacancies = $concierge->getVacancies($user);
        foreach ($vacancies as $vacancy) {
            $this->assertContainsOnly([], $vacancy);
        }
    }

    /**
     * Test Make Successful Reservation
     * @covers            \App\Services\ConciergeService::makeReservation
     */
    public function testMakeSuccessfulReservation()
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

        /* Perform Test */
        $concierge = new ConciergeService(new AvailabilityServiceLayer($business));

        $date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at'))), $business->timezone);

        $appointment = $concierge->makeReservation($issuer, $business, $contact, $service, $date);

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertTrue($appointment->exists);
    }

    /**
     * Test Make Successful Reservation
     * @covers            \App\Services\ConciergeService::makeReservation
     */
    public function testBlockOverbooking()
    {
        /* Setup Stubs */
        $issuer = factory(User::class)->create();
        
        $business = factory(Business::class)->create();
        $business->owners()->save($issuer);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        $vacancy = factory(Vacancy::class)->make();
        $vacancy->capacity = 1;
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);

        $contact = factory(Contact::class)->create();
        $business->contacts()->save($contact);

        /* Perform Test */
        $concierge = new ConciergeService(new AvailabilityServiceLayer($business));

        #$date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at'))), $business->timezone)->timezone('UTC');
        $date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at'))), $business->timezone);

        $appointment = $concierge->makeReservation($issuer, $business, $contact, $service, $date);

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertTrue($appointment->exists);

        /* Try OverBook */
        #$date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at') . ' +30 minutes')), $business->timezone)->timezone('UTC');
        $date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at') . ' +30 minutes')), $business->timezone);

        $appointment = $concierge->makeReservation($issuer, $business, $contact, $service, $date);

        $this->assertFalse($appointment);
    }

    /**
     * Test Attempt Bad Reservation
     * @covers            \App\Services\ConciergeService::makeReservation
     */
    public function testAttemptBadReservation()
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

        /* Perform Test */
        $concierge = new ConciergeService(new AvailabilityServiceLayer($business));

        #$date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at') . ' +1 day')), $business->timezone)->timezone('UTC');
        $date = Carbon::parse(date('Y-m-d H:i:s', strtotime($vacancy->date .' '. $business->pref('start_at') . ' +1 day')), $business->timezone);

        $appointment = $concierge->makeReservation($issuer, $business, $contact, $service, $date);

        $this->assertFalse($appointment);
    }
}
