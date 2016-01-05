<?php

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @covers  App\Http\Controllers\BookingController
 */
class BookingControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use ArrangeFixture, CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @covers   App\Http\Controllers\BookingController::postAction
     * @test
     */
    public function it_annulates_an_existing_appointment()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
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

        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
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
        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->subDays(1),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
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
        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'serve',
            'widget'      => 'panel',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
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

        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_SERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'confirm',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
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

        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment
        $input = [
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'some-invalid-action',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response and see the appointment with no changes
        $this->assertResponseOk();
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

        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment and telling an invalid widgetType
        $input = [
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

        $this->appointment = $this->makeAppointment($this->business, $this->issuer, $this->contact, [
            'service_id' => $this->service->id,
            'vacancy_id' => $this->vacancy->id,
            'status'     => Appointment::STATUS_RESERVED,
            'start_at'   => Carbon::now()->addDays(5),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->issuer);

        // And I request the annulation of the appointment and telling an invalid widgetType
        $input = [
            'business'    => $this->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'serve',
            'widget'      => 'row',
            ];

        $this->post('/api/booking/action', $input);

        // Then I receive a response with error code
        $this->seeJson(['code' => 'OK']);
    }
}
