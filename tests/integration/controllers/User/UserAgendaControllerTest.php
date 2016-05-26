<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Appointment;
use Faker\Factory;

class UserAgendaControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    public function __construct()
    {
        $this->faker = Factory::create();

        parent::__construct();
    }

    /**
     * @test
     */
    public function it_shows_empty_reservations_list()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $this->visit('/')->click('My Reservations');

        $this->see('You have no ongoing reservations by now');
    }

    /**
     * @test
     */
    public function it_shows_reservations_list_with_a_reserved_appointment()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        $this->visit('/')->click('My Reservations');

        $this->see('Reserved')
            ->see($appointment->code)
            ->see($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_shows_reservations_list_omitting_archived_appointments()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $appointment = $this->makeAppointment($business, $user, $contact, [
            'status'   => Appointment::STATUS_SERVED,
            'start_at' => Carbon::now()->subDays(5),
            ]);
        $appointment->service()->associate($service);
        $appointment->save();

        $this->visit('/')->click('My Reservations');

        $this->dontSee('Reserved')
             ->dontSee($appointment->code)
             ->dontSee($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_shows_reservations_list_with_a_canceled_appointment()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_CANCELED]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        $this->visit('/')->click('My Reservations');

        $this->see('Canceled')
            ->see($appointment->code)
            ->see($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_does_not_show_an_inactive_appointment_on_reservations_list()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_CANCELED,
            'start_at' => Carbon::now()->subDays(50),
            ]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        $this->visit('/')->click('My Reservations');

        $this->see('You have no ongoing reservations')
             ->dontSee('Canceled');
    }

    /**
     * @test
     */
    public function it_does_show_an_old_but_active_appointment_on_reservations_list()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(50),
            ]);
        $appointment->issuer()->associate($user);
        $appointment->contact()->associate($contact);
        $appointment->business()->associate($business);
        $appointment->service()->associate($service);
        $appointment->save();

        $this->visit('/')->click('My Reservations');

        $this->see('Reserved')
            ->see($appointment->code)
            ->see($appointment->business->name);
    }

    /**
     * @test
     */
    public function it_queries_vacancies()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->visit(route('user.booking.book', ['business' => $business]));

        $this->see('Select a service to reserve')
             ->see($service->name)
             ->see('Confirm');
    }

    /**
     * @test
     */
    public function it_queries_vacancies_allowing_from_today()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness();
        $business->owners()->save($owner);

        $business->pref('appointment_take_today', true);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->visit(route('user.booking.book', ['business' => $business, 'date' => 'today']));

        $this->see(Carbon::parse('today')->formatLocalized('%A %d %B'));

        $this->see('Select a service to reserve')
             ->see($service->name)
             ->see('Confirm');
    }

    /**
     * @test
     */
    public function it_queries_vacancies_forcing_from_tomorrow()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness();
        $business->owners()->save($owner);

        $business->pref('appointment_take_today', false);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->visit(route('user.booking.book', ['business' => $business, 'date' => 'today']));

        $this->see(Carbon::parse('tomorrow')->formatLocalized('%A %d %B'));

        $this->see('Select a service to reserve')
             ->see($service->name)
             ->see('Confirm');
    }

    /**
     * @test
     */
    public function it_queries_vacancies_skipping_invalid_date_parameter()
    {
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness();
        $business->owners()->save($owner);

        $business->pref('appointment_take_today', false);

        $contact = $this->makeContact($user);
        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->visit(route('user.booking.book', ['business' => $business, 'date' => 'an invalid date string']));

        $this->see(Carbon::parse('tomorrow')->formatLocalized('%A %d %B'));

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
        $owner = $this->createUser();
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->visit(route('user.businesses.home', ['business' => $business]));

        $this->see('Subscribe')
             ->see($business->name);
    }

    //////////////
    // DATESLOT //
    //////////////

    /**
     * @test
     */
    public function it_makes_a_reservation_with_dateslot()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $owner = $this->createUser();
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'dateslot',
            ]);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
        $business->contacts()->save($contact);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'date'        => Carbon::parse('today 00:00 '.$business->timezone)->toDateString(),
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => $this->vacancy->start_at->timezone($business->timezone)->toTimeString(),
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function it_takes_a_reservation_with_dateslot_on_behalf_of()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $owner = $this->createUser();
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'dateslot',
            ]);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
        $business->contacts()->save($contact);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'date'        => Carbon::parse('today 00:00 '.$business->timezone)->toDateString(),
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->actingAs($owner);

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            'contact_id' => $contact->id,
            '_time'      => $this->vacancy->start_at->timezone($business->timezone)->toTimeString(),
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $business->id, 'contact_id' => $contact->id]);
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
            'date'        => Carbon::parse('today 00:00 '.$business->timezone)->toDateString(),
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($user);

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

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

        $business = $this->createBusiness([
            'strategy' => 'dateslot',
            ]);

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'date'        => Carbon::parse('today 00:00 '.$business->timezone)->toDateString(),
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 2,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

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
    public function it_prevents_taking_a_reservation_over_capacity_with_dateslot()
    {
        $userOne = $this->createUser();
        $userTwo = $this->createUser();

        $business = $this->createBusiness([
            'strategy' => 'dateslot',
            ]);

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'date'        => Carbon::parse('today 00:00 '.$business->timezone)->toDateString(),
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

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
        $user = $this->createUser();
        $this->actingAs($user);

        $owner = $this->createUser();
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
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
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function it_takes_a_reservation_with_timeslot_on_shifted_timezone()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $owner = $this->createUser();
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
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

        $shiftedTime = Carbon::parse('09:00:00 '.$business->timezone)->timezone($this->faker->timezone);

        $this->withoutMiddleware();
        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => $shiftedTime->toTimeString(),
            '_timezone'  => $shiftedTime->tzName,
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->timezone($shiftedTime->tzName)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function it_takes_a_reservation_with_timeslot_on_behalf_of()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $owner = $this->createUser();
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($owner);

        $service = $this->makeService();
        $business->services()->save($service);

        $contact = $this->createContact([
            'user_id' => $user->id,
            ]);
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

        $this->actingAs($owner);

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            'contact_id' => $contact->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $business->id, 'contact_id' => $contact->id]);
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

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

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

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

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

        $business = $this->createBusiness([
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($this->createUser());

        $service = $this->makeService();
        $business->services()->save($service);

        $contactOne = $this->makeContact($userOne);
        $contactTwo = $this->makeContact($userTwo);
        $business->contacts()->save($contactOne);
        $business->contacts()->save($contactTwo);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'date'        => Carbon::parse('today 00:00 '.$business->timezone)->toDateString(),
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->withoutMiddleware();

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', ['business' => $business]), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

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
