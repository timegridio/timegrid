<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserBusinessContactControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers   App\Http\Controllers\User\BusinessContactController::create
     * @covers   App\Http\Controllers\User\BusinessContactController::store
     * @covers   App\Http\Controllers\User\BusinessContactController::show
     * @test
     */
    public function it_creates_a_contact_subscription()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $contact = factory(Contact::class)->make(['firstname' => 'John', 'lastname' => 'Doe']);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business contact list section and fill the form
        $this->visit(route("user.businesses.home", $this->business))
             ->click('Subscribe');

        $this->see('Save')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Successfully saved')
             ->see("{$contact->firstname} {$contact->lastname}")
             ->see("Book appointment");
    }

   /**
     * @covers   App\Http\Controllers\User\BusinessContactController::create
     * @covers   App\Http\Controllers\User\BusinessContactController::store
     * @covers   App\Http\Controllers\User\BusinessContactController::show
     * @test
     */
    public function it_creates_a_contact_subscription_reusing_existing_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingContact = factory(Contact::class)->create(['firstname' => 'John', 'lastname' => 'Doe', 'email' => 'test@example.org']);

        $contact = factory(Contact::class)->make(['firstname' => 'John2', 'lastname' => 'Doe2']);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business contact list section and fill the form
        $this->visit(route("user.businesses.home", $this->business))
             ->click('Subscribe');

        $this->see('Save')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($existingContact->email, 'email')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Your profile was attached to an existing one')
             ->see("{$existingContact->firstname} {$existingContact->lastname}");
    }


    /**
     * arrange fixture
     *
     * @return void
     */
    protected function arrangeFixture()
    {
        // A business owned by a user (me)
        $this->owner = factory(User::class)->create();

        $this->issuer = factory(User::class)->create();
        
        $this->business = factory(Business::class)->create();
        $this->business->owners()->save($this->owner);

        // And the business provides a Service
        $this->service = factory(Service::class)->make();
        $this->business->services()->save($this->service);

        // And Service has vacancies to be reserved
        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);
    }
}
