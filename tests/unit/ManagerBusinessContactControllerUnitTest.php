<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
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

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.business.contact.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
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

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.business.contact.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Contact registered successfully')
             ->see("{$contact->firstname} {$contact->lastname}");
        $this->assertEquals($contact->email, $existingUser->contacts()->first()->email);
    }

    /**
     * @covers   App\Http\Controllers\Manager\BusinessContactController::store
     * @covers   App\Http\Controllers\Manager\BusinessContactController::show
     * @test
     */
    public function it_adds_a_contact_to_addressbook_that_matches_an_existing_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingUser = factory(User::class)->create(['name' => 'John', 'email' => 'johndoe@example.org']);

        $existingContact = factory(Contact::class)->create([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.org',
            'nin'       => '123456789',
        ]);
        // And the existing contact belongs to the business addressbok
        $this->business->contacts()->attach($existingContact);

        $contact = factory(Contact::class)->make([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.org',
            'nin'       => '123456789',
        ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.business.contact.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->type($contact->nin, 'nin')
             ->press('Save');

        // Then I see the existing contact found
        $this->assertResponseOk();
        $this->see('We found this existing contact')
             ->see("{$contact->firstname} {$contact->lastname}");
        $this->assertEquals($contact->email, $existingContact->email);
        $this->assertEquals($contact->nin, $existingContact->nin);
    }

    /**
     * arrange fixture.
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
