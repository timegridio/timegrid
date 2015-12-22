<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_annulates_an_existing_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
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
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'annulate',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_ANNULATED, $this->appointment->status);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_annulates_an_existing_appointment_with_panel_widget()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
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
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'annulate',
            'widget'      => 'panel',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_ANNULATED, $this->appointment->status);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_serves_an_existing_appointment_with_panel_widget()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // And the appointment is reserved and past
        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(1),
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
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'serve',
            'widget'      => 'panel',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_SERVED, $this->appointment->status);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_prevents_to_serve_an_existing_future_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // And the appointment is reserved but still future
        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
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
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'serve',
            'widget'      => 'panel',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_RESERVED, $this->appointment->status);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_annulates_fails_to_activate_a_served_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_SERVED,
            'start_at' => Carbon::now()->addDays(5),
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
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'confirm',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_SERVED, $this->appointment->status);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_tries_invalid_action_on_an_existing_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
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
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'some-invalid-action',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment with no changes
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_RESERVED, $this->appointment->status);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_requests_an_invalid_widget()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
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

        // And I request the annulation of the appointment and telling an invalid widgetType
        $input = [
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'annulate',
            'widget'      => 'InvalidWidgetType',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response with error code
        $this->seeJson(['code' => 'ERROR']);
    }

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_serves_an_appointment_and_requests_row_widget()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
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

        // And I request the annulation of the appointment and telling an invalid widgetType
        $input = [
            '_token'      => csrf_token(),
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'serve',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response with error code
        $this->seeJson(['code' => 'OK']);
    }

    /////////////
    // Fixture //
    /////////////

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
