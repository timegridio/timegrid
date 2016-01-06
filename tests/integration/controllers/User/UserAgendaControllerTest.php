<?php

use App\Models\Appointment;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAgendaControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_shows_empty_reservations_list()
    {
        // Given I am an authenticated user
        $user = $this->createUser();
        $this->actingAs($user);

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('My Reservations');

        // Then I should see my empty reservations list
        $this->see('You have no ongoing reservations by now');
    }

    /**
     * @test
     */
    public function it_shows_reservations_list_with_a_reserved_appointment()
    {
        // Given I am an authenticated user
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('My Reservations');

        // Then I should see my reservations list
        // and the reservation details
        $this->see('Reserved')
            ->see($appointment->code)
            ->see($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_shows_reservations_list_with_an_annulated_appointment()
    {
        // Given I am an authenticated user
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_ANNULATED]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('My Reservations');

        // Then I should see my reservations list
        // and the reservation details
        $this->see('Annulated')
            ->see($appointment->code)
            ->see($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_does_not_show_an_inactive_appointment_on_reservations_list()
    {
        // Given I am an authenticated user
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_ANNULATED,
            'start_at' => Carbon::now()->subDays(50),
            ]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('My Reservations');

        // Then I should see my reservations list
        // and the reservation details
        $this->see('You have no ongoing reservations')
             ->dontSee('Annulated');
             #->dontSee($appointment->code)
             #->dontSee($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_does_show_an_old_but_active_appointment_on_reservations_list()
    {
        // Given I am an authenticated user
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(50),
            ]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('My Reservations');

        // Then I should see my reservations list
        // and the reservation details
        $this->see('Reserved')
            ->see($appointment->code)
            ->see($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_queries_vacancies()
    {
        // Given I am an authenticated user
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        // And there is vacancy for the service
        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        // And I go to favourites (subscriptions) section
        $this->visit(route('user.booking.book', ['business' => $business]));

        // WARNING; may return false positive as the view includes the services description

        // Then I should see my reservations list
        // and the reservation details
        $this->see('Select a service to reserve')
             ->see($service->name)
             ->see('Confirm');
    }

    /**
     * @test
     */
    public function it_prevents_showing_vacancies_to_unsubcribed_users()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);

        $this->visit(route('user.booking.book', ['business' => $business]));

        $this->see('To be able to do a reservation you must subscribe the business first');
    }

    /**
     * @test
     */
    public function it_tries_to_query_vacancies_without_subscription()
    {
        // Given I am an authenticated user
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business
        // And which I am NOT subscribed as contact
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        // And there is vacancy for the service (OPTIONAL)
        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        // And I go to business home
        $this->visit(route('user.businesses.home', ['business' => $business]));

        // WARNING; may return false positive as the view includes the services description

        // Then I should see Subscribe button for that business
        $this->see('Subscribe')
             ->see($business->name);
    }

    //////////////
    // DATESLOT //
    //////////////

    /**
     * @test
     */
    public function it_makes_a_reservation()
    {
        // Given I am an authenticated user
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business that provides a service
        $owner = $this->createUser();
        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        // And which I am subscribed-to as contact
        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
        $business->contacts()->save($contact);

        // And there is vacancy for the service (OPTIONAL)
        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        // And I submit the reservation form
        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        // Then I should see Subscribe button for that business
        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function it_prevents_a_duplicated_reservation()
    {
        $user = $this->createUser();

        $business = $this->createBusiness();

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($user);

        // This attempt gets accepted
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        // This attempt gets rejected
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());
    }

    /**
     * @test
     */
    public function it_takes_multiple_reservations_on_same_vacancy()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser();

        $business = $this->createBusiness();

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 2,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        // This attempt gets accepted
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        // This attempt gets rejected
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(2, $business->fresh()->bookings()->get());
    }

    /**
     * @test
     */
    public function it_prevents_taking_a_reservation_over_capacity()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser();

        $business = $this->createBusiness();

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        // This attempt gets accepted
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        // This attempt gets rejected
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());
    }

    /**
     * @test
     */
    public function it_prevents_a_reservation_without_vacancy()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);

        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $otherDayThanVacancy = $this->vacancy->start_at->addDays(7)->timezone($business->timezone)->toDateString();

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $otherDayThanVacancy,
            'comments'   => 'this is an invalid request',
            ]);

        $this->dontSeeInDatabase('appointments', ['business_id' => $business->id]);
    }

    //////////////
    // TIMESLOT //
    //////////////

    /**
     * @test
     */
    public function it_makes_a_reservation_with_timeslot()
    {
        // Given I am an authenticated user
        $user = $this->createUser();
        $this->actingAs($user);

        // And there exist a registered business that provides a service
        $owner = $this->createUser();
        $business = $this->createBusiness(['name' => 'tosto this tosti', 'strategy' => 'timeslot']);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        // And which I am subscribed-to as contact
        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
        $business->contacts()->save($contact);

        // And there is vacancy for the service (OPTIONAL)
        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        // And I submit the reservation form
        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        // Then I should see Subscribe button for that business
        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function it_prevents_a_duplicated_reservation_with_timeslot()
    {
        $user = $this->createUser();

        $business = $this->createBusiness(['strategy' => 'timeslot']);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($user);

        // This attempt gets accepted
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        // This attempt gets rejected
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());
    }

    /**
     * @test
     */
    public function it_takes_multiple_reservations_on_same_vacancy_with_timeslot()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser();

        $business = $this->createBusiness(['strategy' => 'timeslot']);

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 2,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        // This attempt gets accepted
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        // This attempt gets rejected
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(2, $business->fresh()->bookings()->get());
    }

    /**
     * @test
     */
    public function it_prevents_taking_a_reservation_over_capacity_with_timeslot()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser();

        $business = $this->createBusiness(['strategy' => 'timeslot']);

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        // This attempt gets accepted
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        // This attempt gets rejected
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());
    }

    /**
     * @test
     */
    public function it_prevents_a_reservation_without_vacancy_with_timeslot()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti', 'strategy' => 'timeslot']);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);

        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $otherDayThanVacancy = $this->vacancy->start_at->addDays(7)->timezone($business->timezone)->toDateString();

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $otherDayThanVacancy,
            'comments'   => 'this is an invalid request',
            ]);

        $this->dontSeeInDatabase('appointments', ['business_id' => $business->id]);
    }
}
