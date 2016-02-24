<?php

use Timegridio\Concierge\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerBusinessAgendaControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use ArrangeFixture, CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_verifies_no_appointments_in_business_agenda()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business agenda section
        $this->visit(route('user.agenda', $this->business));

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();

        // Then I see the appointment listed
        $this->see('You have no ongoing reservations');
    }

    /**
     * @test
     */
    public function it_verifies_appointments_in_business_agenda()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = $this->createAppointment([
            'issuer_id'   => $this->issuer->id,
            'business_id' => $this->business->id,
            'service_id'  => $this->service->id,
            'contact_id'  => $this->contact->id,
            'vacancy_id'  => $this->vacancy->id,
            'status'      => Appointment::STATUS_RESERVED,
            'duration'    => 30,
            'start_at'    => $this->vacancy->start_at,
            'finish_at'   => $this->vacancy->start_at->addHours(1),
            ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);

        $this->visit(route('manager.business.agenda.index', $this->business));

        $this->assertResponseOk();

        $this->see($this->appointment->code);
    }
}
