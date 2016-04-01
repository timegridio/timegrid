<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class ManagerAddressbookControllerTest extends TestCase
{
    use DatabaseTransactions;
    use ArrangeFixture, CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_adds_a_contact_to_addressbook()
    {
        $this->arrangeFixture();

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.addressbook.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->press('Save');

        $this->assertResponseOk();
        $this->see('Contact registered successfully')
             ->see("{$contact->firstname} {$contact->lastname}");
    }

    /**
     * @test
     */
    public function it_edits_a_contact_of_addressbook()
    {
        $this->arrangeFixture();

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe', 'nin' => '1133224455',
            ]);
        $this->business->contacts()->save($contact);

        $this->actingAs($this->owner);

        $this->visit(route('manager.addressbook.edit', ['business' => $this->business->slug, 'contact' => $contact->id]))
             ->see($contact->firstname)
             ->see($contact->lastname)
             ->see($contact->nin);

        $this->type('NewName', 'firstname')
             ->type('NewLastName', 'lastname')
             ->press('Update');

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
        $this->arrangeFixture();

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
        $this->arrangeFixture();

        $unauthorizedUser = $this->createUser();

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

        $this->actingAs($this->owner);

        $this->visit(route('manager.addressbook.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->press('Save');

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

        $this->actingAs($this->owner);

        $this->visit(route('manager.addressbook.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->press('Save');

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

        $this->business->contacts()->attach($existingContact);

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'johndoe@example.org',
            'nin'       => '123456789',
        ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.addressbook.index', $this->business))
             ->click('Add a contact')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->type($contact->email, 'email')
             ->type($contact->nin, 'nin')
             ->press('Save');

        $this->assertResponseOk();
        $this->see('We found this existing contact')
             ->see("{$contact->firstname} {$contact->lastname}");
        $this->assertEquals($contact->email, $existingContact->email);
        $this->assertEquals($contact->nin, $existingContact->nin);
    }
}
