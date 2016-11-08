<?php

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Appointment;

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

        $this->visit('/home')->click('My Reservations');

        $this->see('You have no ongoing reservations.');
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

        $this->visit('/home')->click('My Reservations');

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

        $this->visit('/home')->click('My Reservations');

        $this->see('You have no ongoing reservations')
             ->dontSee('Reserved')
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

        $this->visit('/home')->click('My Reservations');

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

        $this->visit('/home')->click('My Reservations');

        $this->see('You have no ongoing reservations.')
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

        $this->visit('/home')->click('My Reservations');

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

        $this->visit(route('user.booking.book', compact('business')));

        $this->see('Select a service to reserve')
             ->see($service->name)
             ->see('Confirm');
    }

    /**
     * @test
     */
    public function it_queries_vacancies_on_behalf_of_a_contact()
    {
        $owner = $this->createUser();
        $user = $this->createUser();

        $business = $this->createBusiness(['name' => 'tosto this tosti']);
        $business->owners()->save($owner);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);
        
        $this->actingAs($owner);

        $this->visit(route('user.booking.book', ['business' => $business, 'behalfOfId' => $contact->id]));

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

        $this->visit(route('user.businesses.home', compact('business')));

        $this->see('Subscribe')
             ->see($business->name);
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

        $this->actingAs($user);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $otherDayThanVacancy,
            'comments'   => 'this is an invalid request',
            ]);

        $this->dontSeeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function a_listed_guest_user_may_make_a_soft_appointment()
    {
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'timeslot',
            ]);

        $business->pref('allow_guest_registration', false);

        $contact = $this->makeContact();
        $contact->email = 'guest@example.org';
        $business->contacts()->save($contact);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            'email'      => 'guest@example.org',
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('contacts', ['email' => 'guest@example.org']);
        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
    }

    /**
     * @test
     */
    public function an_unlisted_guest_user_may_make_a_soft_appointment()
    {
        $owner = $this->createUser();
        $business = $this->createBusiness([
            'name'     => 'tosto this tosti',
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($owner);

        $business->pref('allow_guest_registration', true);

        $service = $this->makeService();
        $business->services()->save($service);

        $this->vacancy = $this->makeVacancy([
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'start_at'    => Carbon::parse('today 08:00 '.$business->timezone)->timezone('utc'),
            'finish_at'   => Carbon::parse('today 22:00 '.$business->timezone)->timezone('utc'),
            'capacity'    => 1,
            ]);
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            'email'      => 'unlisted-guest@example.org',
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->seeInDatabase('appointments', ['business_id' => $business->id]);
        $this->seeInDatabase('contacts', ['email' => 'unlisted-guest@example.org']);
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

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->call('POST', route('user.booking.store', compact('business')), [
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
    public function it_validates_a_soft_appotinment_through_a_mailed_link()
    {
        $owner = $this->createUser();
        $business = $this->createBusiness([
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($owner);

        $contact = $this->createContact([
            'user_id' => null,
            ]);
        $business->contacts()->save($contact);

        $appointment = $this->makeSoftAppointment($business, $contact, ['status' => Appointment::STATUS_RESERVED]);
        $appointment->save();

        $code = $appointment->code;
        $email = $appointment->contact->email;

        $this->visit(route('user.booking.validate', compact('business', 'code', 'email')));

        $this->see('You confirmed your appointment successfully');
        $this->see($appointment->code);
    }

    /**
     * @test
     */
    public function it_rejects_validation_of_soft_appotinment_with_incomplete_appointment_codes()
    {
        $owner = $this->createUser();
        $business = $this->createBusiness([
            'strategy' => 'timeslot',
            ]);
        $business->owners()->save($owner);

        $contact = $this->createContact([
            'user_id' => null,
            ]);
        $business->contacts()->save($contact);

        $appointment = $this->makeSoftAppointment($business, $contact, ['status' => Appointment::STATUS_RESERVED]);
        $appointment->save();

        $code = substr($appointment->code, 0, 1);
        $email = $appointment->contact->email;

        $this->visit(route('user.booking.validate', compact('business', 'code', 'email')));

        $this->see('Sorry, invalid appointment code');
        $this->dontSee($appointment->code);
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


        $this->actingAs($user);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->actingAs($userOne);

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $this->vacancy->start_at->timezone($business->timezone)->toDateString(),
            'comments'   => 'test comments',
            ]);

        $this->assertCount(1, $business->fresh()->bookings()->get());

        $this->actingAs($userTwo);

        $this->call('POST', route('user.booking.store', compact('business')), [
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

        $this->call('POST', route('user.booking.store', compact('business')), [
            'businessId' => $business->id,
            'service_id' => $service->id,
            '_time'      => '09:00:00',
            '_date'      => $otherDayThanVacancy,
            'comments'   => 'this is an invalid request',
            ]);

        $this->dontSeeInDatabase('appointments', ['business_id' => $business->id]);
    }
}
