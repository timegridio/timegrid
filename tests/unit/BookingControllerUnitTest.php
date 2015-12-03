<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers            \App\Models\Business::__construct
     * @test
     */
    public function it_annulates_an_existing_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status' => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5)
            ]);
        $this->appointment->issuer()->associate($this->issuer);
        $this->appointment->business()->associate($this->business);
        $this->appointment->service()->associate($this->service);
        $this->appointment->contact()->associate($this->contact);
        $this->appointment->vacancy()->associate($this->vacancy);
        $this->appointment->save();

        // And I am authenticated
        session()->start();
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
            '_token' => csrf_token(),
            'business' => $this->business->id,
            'appointment' => $this->appointment->id,
            'action' => 'annulate',
            'widget' => 'row'
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();

        // Then I receive a response
        $this->assertEquals(Appointment::STATUS_ANNULATED, $this->appointment->status);
    }

   /**
     * @covers            \App\Models\Business::__construct
     * @test
     */
    public function it_annulates_fails_to_activate_a_served_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status' => Appointment::STATUS_SERVED,
            'start_at' => Carbon::now()->addDays(5)
            ]);
        $this->appointment->issuer()->associate($this->issuer);
        $this->appointment->business()->associate($this->business);
        $this->appointment->service()->associate($this->service);
        $this->appointment->contact()->associate($this->contact);
        $this->appointment->vacancy()->associate($this->vacancy);
        $this->appointment->save();

        // And I am authenticated
        session()->start();
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
            '_token' => csrf_token(),
            'business' => $this->business->id,
            'appointment' => $this->appointment->id,
            'action' => 'confirm',
            'widget' => 'row'
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();

        // Then I receive a response
        $this->assertEquals(Appointment::STATUS_SERVED, $this->appointment->status);
    }

    protected function arrangeFixture()
    {
        // A business owned by a user (me)
        $this->issuer = factory(User::class)->create();
        
        $this->business = factory(Business::class)->create();
        $this->business->owners()->save($this->issuer);

        // And the business provides a Service
        $this->service = factory(Service::class)->make();
        $this->business->services()->save($this->service);

        // And Service has vacancies to be reserved
        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        // And a Contact that holds an appointment for the service
        $this->contact = factory(Contact::class)->create();
    }
}
