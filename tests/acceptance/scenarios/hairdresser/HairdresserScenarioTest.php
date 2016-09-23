<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Humanresource;

class HairdresserScenarioTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    protected $issuer;

    protected $business;

    protected $vacancy;
    
    // protected $service;


    /**
     * @test
     */
    public function it_fits_for_hairdresser_scenario()
    {
        $this->arrangeScenario();

        $this->the_business_publishes_a_service(['name' => 'Hair Cut', 'duration' => 20]);
        $this->the_business_publishes_a_service(['name' => 'Washing', 'duration' => 10]);
        $this->the_business_publishes_a_service(['name' => 'Brushing', 'duration' => 55]);
        $this->the_business_registers_the_staff();
        $this->the_business_publishes_vacancies();
        $this->a_user_subscribes_to_business();
        $this->the_user_queries_vacancies();
        $this->it_provides_available_times_for_requested_service_date();
        $this->the_user_takes_a_reservation();
        $this->the_user_sees_the_reservation_ticket();
        $this->a_user_b_takes_a_reservation();
        $this->a_user_c_takes_a_tight_reservation();
        $this->it_provides_available_times_for_remaining_service();
    }

    public function the_business_registers_the_staff()
    {
        $staff = new Humanresource(['name' => 'nadia', 'capacity' => 1]);

        $this->business->humanresources()->save($staff);

        $this->seeInDatabase('humanresources', ['business_id' => $this->business->id, 'name' => $staff->name]);
    }

    public function the_business_publishes_a_service($serviceData)
    {
        $service = $this->makeService($serviceData);

        $this->actingAs($this->owner);

        $this->call('POST', route('manager.business.service.store', $this->business), $service->toArray());

        $this->seeInDatabase('services', ['business_id' => $this->business->id, 'name' => $service->name]);
    }

    public function the_business_publishes_vacancies()
    {
        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $sheet =
<<<EOD
hair-cut:nadia,washing:nadia,brushing:nadia
 tue, thu, sat
  9-18
EOD;
        $this->type($sheet, 'vacancies');

        $this->press('Update');

        $this->assertResponseOk();
        $this->see('Availability registered successfully');
    }

    public function a_user_subscribes_to_business()
    {
        $contact = [
            'firstname' => 'John',
            'lastname'  => 'Doe',
            ];

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business contact list section and fill the form
        $this->visit(route('user.businesses.home', $this->business))
             ->click('Subscribe');

        $this->see('Save')
             ->type($contact['firstname'], 'firstname')
             ->type($contact['lastname'], 'lastname')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Successfully saved')
             ->see("{$contact['firstname']} {$contact['lastname']}")
             ->see('Book appointment');
    }

    public function the_user_queries_vacancies()
    {
        $this->actingAs($this->issuer);

        $this->visit(route('user.booking.book', ['business' => $this->business]));

        $contact = [
            'firstname' => 'John',
            'lastname'  => 'Doe',
            ];

        $this->click('Subscribe');

        $this->see('Your profile was attached to an existing one');

        $this->click('Book appointment');
    }

    public function it_provides_available_times_for_requested_service_date()
    {
        $this->actingAs($this->issuer);

        $service = $this->business->services()->where('slug', 'hair-cut')->first();

        $this->vacancy = $this->business->vacancies()->first();

        $this->get("api/vacancies/{$this->business->id}/{$service->id}/{$this->vacancy->date}");

        $this->assertResponseOk();
        $this->seeJsonContains(['times' => ["09:00","09:20","09:40","10:00","10:20","10:40","11:00","11:20","11:40","12:00","12:20","12:40","13:00","13:20","13:40","14:00","14:20","14:40","15:00","15:20","15:40","16:00","16:20","16:40","17:00","17:20","17:40"]]);
    }

    public function the_user_takes_a_reservation()
    {
        $this->actingAs($this->issuer->fresh());

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $this->business]), [
            'businessId' => $this->business->id,
            'service_id' => $this->business->services()->where('slug', 'hair-cut')->first()->id,
            '_time'      => '09:00',
            '_date'      => $this->vacancy->date,
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $this->business->id]);
    }

    public function the_user_sees_the_reservation_ticket()
    {
        $this->actingAs($this->issuer->fresh());

        $this->visit(route('user.businesses.home', ['business' => $this->business]));

        $this->see('Hair Cut')
             ->see('Please arrive at 09:00 am')
             ->see($this->issuer->fresh()->appointments()->first()->code);
    }

    public function a_user_b_takes_a_reservation()
    {
        $issuer = $this->createUser();
        $this->actingAs($issuer);

        $contact = $this->makeContact($issuer);

        $this->business->contacts()->save($contact); 

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $this->business]), [
            'businessId' => $this->business->id,
            'service_id' => $this->business->services()->where('slug', 'brushing')->first()->id,
            '_time'      => '09:30',
            '_date'      => $this->vacancy->date,
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $this->business->id, 'issuer_id' => $issuer->id]);
    }

    public function a_user_c_takes_a_tight_reservation()
    {
        $issuer = $this->createUser();
        $this->actingAs($issuer);

        $contact = $this->makeContact($issuer);

        $this->business->contacts()->save($contact); 

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $this->business]), [
            'businessId' => $this->business->id,
            'service_id' => $this->business->services()->where('slug', 'washing')->first()->id,
            '_time'      => '09:20',
            '_date'      => $this->vacancy->date,
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $this->business->id, 'issuer_id' => $issuer->id]);
    }

    public function it_provides_available_times_for_remaining_service()
    {
        $this->actingAs($this->issuer);

        $service = $this->business->services()->where('slug', 'washing')->first();

        $this->vacancy = $this->business->vacancies()->first();

        $this->get("api/vacancies/{$this->business->id}/{$service->id}/{$this->vacancy->date}");

        $this->assertResponseOk();
        $this->seeJsonContains(['times' => ["10:30","10:40","10:50","11:00","11:10","11:20","11:30","11:40","11:50","12:00","12:10","12:20","12:30","12:40","12:50","13:00","13:10","13:20","13:30","13:40","13:50","14:00","14:10","14:20","14:30","14:40","14:50","15:00","15:10","15:20","15:30","15:40","15:50","16:00","16:10","16:20","16:30","16:40","16:50","17:00","17:10","17:20","17:30","17:40","17:50"]]);
    }


    /**
     * Arrange Fixture.
     *
     * @return void
     */
    protected function arrangeScenario()
    {
        $this->owner = $this->createUser();

        $this->issuer = $this->createUser();

        $this->business = $this->createBusiness([
            'strategy' => 'timeslot',
            ]);

        $this->business->owners()->save($this->owner);

        $this->business->pref('vacancy_edit_advanced_mode', true);
        $this->business->pref('timeslot_step', 0);
        $this->business->pref('time_format', 'h:i a');
    }
}
