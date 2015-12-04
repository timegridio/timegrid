<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagerBusinessContactControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers   App\Http\Controllers\Manager\BusinessContactController::index
     * @covers   App\Http\Controllers\Manager\BusinessContactController::create
     * @covers   App\Http\Controllers\Manager\BusinessContactController::store
     * @covers   App\Http\Controllers\Manager\BusinessContactController::show
     * @test
     */
    public function it_adds_a_contact_to_addressbook()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $contact = factory(Contact::class)->make(['firstname' => 'John', 'lastname' => 'Doe']);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business contact list section
        $this->visit("/manager/business/{$this->business->id}/contact")
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->press('Save');

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();

        // Then I see the appointment listed
        $this->see('Contact registered successfully')
             ->see("{$contact->firstname} {$contact->lastname}");
    }

   /**
     * @covers   App\Http\Controllers\Manager\BusinessContactController::index
     * @covers   App\Http\Controllers\Manager\BusinessContactController::create
     * @covers   App\Http\Controllers\Manager\BusinessContactController::store
     * @covers   App\Http\Controllers\Manager\BusinessContactController::show
     * @test
     */
    public function it_adds_a_contact_to_addressbook_that_links_to_existing_user()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingUser = factory(User::class)->create(['name' => 'John', 'email' => 'johndoe@example.org']);

        $contact = factory(Contact::class)->make(['firstname' => 'John', 'lastname' => 'Doe', 'email' => 'johndoe@example.org']);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business contact list section
        $this->visit("/manager/business/{$this->business->id}/contact")
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->press('Save');

        // Then I receive a response and see the appointment annulated
        $this->assertResponseOk();

        // Then I see the appointment listed
        $this->see('Contact registered successfully')
             ->see("{$contact->firstname} {$contact->lastname}");
        $this->assertEquals($contact->email, $existingUser->contacts()->first()->email);
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
    }
}
