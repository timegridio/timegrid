<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class UserContactControllerTest extends TestCase
{
    use DatabaseTransactions;
    use ArrangeFixture, CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService, CreateVacancy;

    /**
     * @test
     */
    public function it_creates_a_contact_subscription()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            ]);

        // And I am authenticated as the business owner
        $this->actingAs($this->createUser());

        // And I visit the business contact list section and fill the form
        $this->visit(route('user.businesses.home', $this->business))
             ->click('Subscribe');

        $this->see('Save')
             ->type($contact->firstname, 'firstname')
             ->type($contact->lastname, 'lastname')
             ->press('Save');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Successfully saved')
             ->see("{$contact->firstname} {$contact->lastname}")
             ->see('Book appointment');
    }

    /**
     * @test
     */
    public function it_creates_a_contact_subscription_reusing_existing_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();
        $existingContact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'test@example.org',
            ]);
        $this->business->contacts()->save($existingContact);

        $contact = $this->createContact([
            'firstname' => 'John2',
            'lastname'  => 'Doe2',
            ]);

        $this->actingAs($this->createUser([
            'email' => $existingContact->email, ]
            ));

        // And I visit the business contact list section and fill the form
        $this->visit(route('user.businesses.home', $this->business))
             ->click('Subscribe');

        // Then I see the contact registered
        $this->assertResponseOk();
        $this->see('Your profile was attached to an existing one')
             ->see("{$existingContact->firstname} {$existingContact->lastname}");
        $this->assertEquals(true, $existingContact->businesses->contains($this->business));
    }

    /**
     * @test
     */
    public function it_creates_a_contact_subscription_copying_existing_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // I have a registered contact in Business A (other business)
        $otherBusiness = $this->createBusiness();

        $issuer = $this->createUser();

        $existingContact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'email'     => 'test@example.org',
            ]);
        $existingContact->user()->associate($issuer);
        $otherBusiness->contacts()->save($existingContact);

        // And I am authenticated as the business owner
        $this->actingAs($issuer);

        $beforeCount = $issuer->contacts->count();

        // And I visit the business home to get subscribed
        $this->visit(route('user.businesses.home', $this->business))
             ->click('Subscribe');

        $afterCount = $issuer->fresh()->contacts->count();

        // Then I am not requested for form filling and get my contact copied from existing
        $this->assertResponseOk();
        $this->see('Your profile was attached to an existing one')
             ->see("{$existingContact->firstname} {$existingContact->lastname}");
        $this->assertEquals($afterCount, $beforeCount + 1);
    }

    /**
     * @test
     */
    public function it_edits_a_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // I have a registered contact in Business
        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'nin'       => null,
            'email'     => null,
            ]);
        $contact->user()->associate($this->issuer);
        $this->business->contacts()->save($contact);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the contact edit form
        // And set a NIN and and submit
        $this->visit(route('user.business.contact.edit', ['business' => $this->business, 'contact' => $contact]))
             ->type('1122334455', 'nin')
             ->press('Update');

        // Then I see the profile is updated with the NIN
        $this->assertResponseOk();
        $this->see('Updated successfully')
             ->see('1122334455');
    }

    /**
     * @test
     */
    public function it_cannot_edit_an_unowned_contact()
    {
        $this->arrangeFixture();

        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'nin'       => null,
            'email'     => null,
            ]);

        $this->business->contacts()->save($contact);

        $this->actingAs($this->issuer);

        try {
            $this->visit(route('user.business.contact.edit', [
                'business' => $this->business,
                'contact'  => $contact,
                ]));
        } catch (Exception $e) {
            $this->assertResponseStatus(403);
        }
    }

    /**
     * @test
     */
    public function it_can_change_nin_of_a_contact()
    {
        // Given a fixture of
        $this->arrangeFixture();

        // I have a registered contact in Business
        $contact = $this->createContact([
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'nin'       => '12345',
            'email'     => null,
            ]);
        $contact->user()->associate($this->issuer);
        $this->business->contacts()->save($contact);

        // And I am authenticated as the business owner
        $this->actingAs($this->issuer);

        // And I visit the contact edit form
        // And set a NIN and and submit
        $newNin = '54321';

        $this->visit(route('user.business.contact.edit', ['business' => $this->business, 'contact' => $contact]))
             ->type($newNin, 'nin')
             ->press('Update');

        // Then I see the profile is updated with the NIN
        $this->assertResponseOk();
        $this->see('Updated successfully')
             ->see($newNin);
    }

    /**
     * @test
     */
    public function it_detaches_a_contact_from_business()
    {
        // Given a fixture of
        $this->arrangeFixture();

        $this->actingAs($this->issuer);
        $this->withoutMiddleware();

        $this->assertCount(1, $this->business->fresh()->contacts);

        $response = $this->call('DELETE', route('user.business.contact.destroy', ['business' => $this->business, 'contact' => $this->contact]));

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertCount(0, $this->business->fresh()->contacts);
    }
}
