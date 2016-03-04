<?php

use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagerAddressbookControllerTest extends TestCase
{
    use DatabaseTransactions;
    use ArrangeFixture, CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_adds_a_contact_to_addressbook()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.addressbook.index', $this->business))
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
     * @test
     */
    public function it_edits_a_contact_of_addressbook()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe', 'nin' => '1133224455',
            ]);
        $this->business->contacts()->save($contact);

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);

        // And I visit the business contact edit form
        $this->visit(route('manager.addressbook.edit', ['business' => $this->business->slug, 'contact' => $contact->id]))
             ->see($contact->firstname)
             ->see($contact->lastname)
             ->see($contact->nin);

        // And I change the name and lastname
        $this->type('NewName', 'firstname')
             ->type('NewLastName', 'lastname')
             ->press('Update');

        // Then I see the contact updated on the list
        $this->assertResponseOk();
        $this->see('Updated successfully')
             ->see('NewName')
             ->see('NewLastName');
    }

    /**
     * @test
     */
    public function it_detaches_a_contact_from_business()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);
        $this->withoutMiddleware();

        $this->assertCount(1, $this->business->fresh()->contacts);

        $response = $this->call('DELETE', route('manager.addressbook.destroy', [$this->business, $this->contact]));

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertCount(0, $this->business->fresh()->contacts);
    }

    /**
     * @test
     */
    public function it_denies_detaching_a_contact_from_business_to_unauthorized_user()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $unauthorizedUser = $this->createUser();

        // And I am authenticated as the business owner
        $this->actingAs($unauthorizedUser);
        $this->withoutMiddleware();

        $this->assertCount(1, $this->business->fresh()->contacts);

        $response = $this->call('DELETE', route('manager.addressbook.destroy', [$this->business, $this->contact]));

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertCount(1, $this->business->fresh()->contacts);
    }

    /**
     * @test
     */
    public function it_adds_a_contact_to_addressbook_that_links_to_existing_user()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingUser = $this->createUser([
            'name'  => 'John',
            'email' => 'johndoe@example.org',
            ]);

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.org',
            ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.addressbook.index', $this->business))
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
     * @test
     */
    public function it_adds_a_contact_to_addressbook_that_does_not_link_a_user()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingUser = $this->createUser([
            'name'  => 'John',
            'email' => 'johndoe@example.org',
            ]);

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'another-not-in-users@example.org',
            ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.addressbook.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Contact registered successfully')
             ->see("{$contact->firstname} {$contact->lastname}");
        $this->assertNull($contact->user);
    }

    /**
     * @test
     */
    public function it_adds_a_contact_to_addressbook_that_matches_an_existing_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingUser = $this->createUser([
            'name'  => 'John',
            'email' => 'johndoe@example.org',
            ]);

        $existingContact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.org',
            'nin'       => '123456789',
        ]);
        // And the existing contact belongs to the business addressbok
        $this->business->contacts()->attach($existingContact);

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.org',
            'nin'       => '123456789',
        ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->owner);

        // And I visit the business contact list section and fill the form
        $this->visit(route('manager.addressbook.index', $this->business))
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
}
