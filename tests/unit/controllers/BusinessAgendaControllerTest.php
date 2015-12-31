<?php

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BusinessAgendaControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @covers   App\Http\Controllers\Manager\BusinessAgendaController::getIndex
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
     * @covers   App\Http\Controllers\Manager\BusinessAgendaController::getIndex
     * @test
     */
    public function it_verifies_appointments_in_business_agenda()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->appointment = $this->createAppointment([
            'issuer_id' => $this->issuer->id,
            'business_id' => $this->business->id,
            'service_id' => $this->service->id,
            'contact_id' => $this->contact->id,
            'vacancy_id' => $this->vacancy->id,
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->addDays(5),
            ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        $this->visit(route('manager.business.agenda.index', $this->business));

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();

        // Then I see the appointment listed
        $this->see($this->appointment->code);
    }

    /////////////
    // Fixture //
    /////////////

    /**
     * arrange fixture.
     *
     * @return void
     */
    protected function arrangeFixture()
    {
        // Given there is...

        // a Business owned by Me (User)
        $this->issuer = $this->createUser();

        $this->business = $this->createBusiness();
        $this->business->owners()->save($this->issuer);

        // And the Business provides a Service
        $this->service = $this->makeService();
        $this->business->services()->save($this->service);

        // And the Service has Vacancies to be reserved
        $this->vacancy = $this->makeVacancy();
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        // And a Contact that holds an Appointment for that Service
        $this->contact = $this->createContact();
    }
}
