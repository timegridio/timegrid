<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAgendaControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * user.
     *
     * @var User user
     */
    private $user;

    ///////////
    // TESTS //
    ///////////

    /** @test */
    public function it_shows_empty_reservations_list()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('My Reservations');

        // Then I should see my reservations list
        // and which is is empty
        $this->see('You have no ongoing reservations by now');
    }

    /** @test */
    public function it_shows_reservations_list_with_a_reserved_appointment()
    {
        // Given I am an authenticated user
        $this->owner = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);
        $contact = factory(Contact::class)->create();
        $contact->user()->associate($this->user);
        $contact->save();
        $business->contacts()->save($contact);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->issuer()->associate($this->user);
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

    /** @test */
    public function it_shows_reservations_list_with_an_annulated_appointment()
    {
        // Given I am an authenticated user
        $this->owner = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);
        $contact = factory(Contact::class)->create();
        $contact->user()->associate($this->user);
        $contact->save();
        $business->contacts()->save($contact);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_ANNULATED]);
        $appointment->issuer()->associate($this->user);
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

    /** @test */
    public function it_does_not_show_an_inactive_appointment_on_reservations_list()
    {
        // Given I am an authenticated user
        $this->owner = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);
        $contact = factory(Contact::class)->create();
        $contact->user()->associate($this->user);
        $contact->save();
        $business->contacts()->save($contact);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_ANNULATED,
            'start_at' => Carbon::now()->subDays(50),
            ]);
        $appointment->issuer()->associate($this->user);
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

    /** @test */
    public function it_does_show_an_old_but_active_appointment_on_reservations_list()
    {
        // Given I am an authenticated user
        $this->owner = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);
        $contact = factory(Contact::class)->create();
        $contact->user()->associate($this->user);
        $contact->save();
        $business->contacts()->save($contact);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And I have a RESERVED appointment
        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(50),
            ]);
        $appointment->issuer()->associate($this->user);
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

    /** @test */
    public function it_queries_vacancies()
    {
        // Given I am an authenticated user
        $this->owner = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        // And which I am subscribed as contact
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);
        $contact = factory(Contact::class)->create();
        $contact->user()->associate($this->user);
        $contact->save();
        $business->contacts()->save($contact);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And there is vacancy for the service
        $this->vacancy = factory(Vacancy::class)->make();
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

    /** @test */
    public function it_tries_to_query_vacancies_without_subscription()
    {
        // Given I am an authenticated user
        $this->owner = factory(User::class)->create();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        // And which I am NOT subscribed as contact
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And there is vacancy for the service (OPTIONAL)
        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->service()->associate($service);
        $business->vacancies()->save($this->vacancy);

        // And I go to business home
        $this->visit(route('user.businesses.home', ['business' => $business]));

        // WARNING; may return false positive as the view includes the services description

        // Then I should see Subscribe button for that business
        $this->see('Subscribe')
             ->see($business->name);
    }

    /** @test */
    public function it_makes_a_reservation()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business that provides a service
        $this->owner = factory(User::class)->create();
        $business = factory(Business::class)->create(['name' => 'tosto this tosti']);
        $business->owners()->save($this->owner);

        $service = factory(Service::class)->make();
        $business->services()->save($service);

        // And which I am subscribed-to as contact
        $contact = factory(Contact::class)->create([
            'user_id' => $this->user->id,
            ]);
        $business->contacts()->save($contact);

        // And there is vacancy for the service (OPTIONAL)
        $this->vacancy = factory(Vacancy::class)->make([
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
}
