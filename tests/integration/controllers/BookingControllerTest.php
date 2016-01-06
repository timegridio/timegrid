<?php

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
#use Illuminate\Foundation\Testing\WithoutMiddleware;

class BookingControllerTest extends TestCase
{
    use DatabaseTransactions;
    # use WithoutMiddleware;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
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
            'start_at'   => Carbon::now()->addDays(7),
            ]);
        $this->appointment->save();

        // And I am authenticated
        $this->actingAs($this->appointment->issuer);

        // And I request the annulation of the appointment
        $input = [
            'business'    => $this->appointment->business->id,
            'appointment' => $this->appointment->id,
            'action'      => 'annulate',
            'widget'      => 'row',
            ];

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->assertEquals(Appointment::STATUS_ANNULATED, $this->appointment->fresh()->status);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_ANNULATED, $this->appointment->status);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
        $this->appointment = $this->appointment->fresh();
        $this->assertEquals(Appointment::STATUS_SERVED, $this->appointment->status);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
        $this->assertEquals(Appointment::STATUS_RESERVED, $this->appointment->status);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response and see the appointment served
        $this->assertResponseOk();
        $this->assertEquals(Appointment::STATUS_SERVED, $this->appointment->status);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response and see the appointment with no changes
        $this->assertResponseOk();
        $this->assertEquals(Appointment::STATUS_RESERVED, $this->appointment->status);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response with error code
        $this->seeJson(['code' => 'ERROR']);
    }

    /**
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

        $this->post(route('api.booking.action'), $input);

        // Then I receive a response with error code
        $this->seeJson(['code' => 'OK']);
    }

    /**
     * Arrange Fixture.
     *
     * @return void
     */
    protected function arrangeFixture()
    {
        // Given there is...

        // a Business owned by Me (User)
        $this->owner = $this->createUser();

        $this->issuer = $this->createUser();

        $this->business = $this->createBusiness();
        $this->business->owners()->save($this->owner);

        $this->contact = $this->createContact();

        $this->contact->user()->associate($this->issuer);        

        // And the Business provides a Service
        $this->service = $this->makeService();
        $this->business->services()->save($this->service);

        // And the Service has Vacancies to be reserved
        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);
    }
}
