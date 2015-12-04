<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessAgendaControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

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
        $this->visit("/manager/agenda/{$this->business->id}");

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();

        // Then I see the appointment listed
        $this->see('There are no active appointments right now');
    }

   /**
     * @covers   App\Http\Controllers\Manager\BusinessAgendaController::getIndex
     * @test
     */
    public function it_verifies_appointments_in_business_agenda()
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

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        $this->visit("/manager/agenda/{$this->business->id}");

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();

        // Then I see the appointment listed
        $this->see($this->appointment->code);
        $this->see($this->appointment->contact->firstname);
    }

    /**
     * arrange fixture
     * 
     * @return void
     */
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
