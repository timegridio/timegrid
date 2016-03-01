<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoursesScenarioTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_fits_for_courses_scenario()
    {
        $this->arrangeScenario();

        $this->the_business_publishes_a_course_service();
        $this->the_business_publishes_vacancies();
        $this->a_user_subscribes_to_business();
        $this->a_user_queries_vacancies();
        $this->it_provides_available_times_for_requested_service_date();
    }

    public function the_business_publishes_a_course_service()
    {
        $service = $this->makeService([
            'name'     => 'First Day Free Pass',
            'duration' => 60,
            ]);

        $this->actingAs($this->owner);

        $this->call('POST', route('manager.business.service.store', $this->business), $service->toArray());

        $this->assertCount(1, $this->business->fresh()->services);
    }

    public function the_business_publishes_vacancies()
    {
        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $sheet =
<<<EOD
first-day-free-pass:20
 tue, thu, sat
  19-21
EOD;
        $this->type($sheet, 'vacancies');

        $this->press('Update');

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->see('Availability registered successfully');
    }

    public function a_user_queries_vacancies()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $contact = $this->makeContact($user);

        $this->business->contacts()->save($contact);

        $this->visit(route('user.booking.book', ['business' => $this->business]));

        $this->see('Reserve appointment')
             ->see('First Day Free Pass')
             ->see('Book appointment');
    }

    public function a_user_subscribes_to_business()
    {
        $contact = [
            'firstname' => 'John',
            'lastname'  => 'Doe',
            ];

        // And I am authenticated as the business owner
        $this->actingAs($this->createUser());

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

    public function it_provides_available_times_for_requested_service_date()
    {
        $this->actingAs($this->issuer);

        $service = $this->business->services()->first();

        $vacancy = $this->business->vacancies()->first();

        $this->get("api/vacancies/{$this->business->id}/{$service->id}/{$vacancy->date}");

        $this->assertResponseOk();
        $this->seeJsonContains(['times' => ['19:00:00', '20:00:00']]);
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

        $this->contact = $this->createContact();

        $this->contact->user()->associate($this->issuer);
    }
}
