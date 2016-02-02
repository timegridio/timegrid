<?php

use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;
use App\Models\User;
use App\Presenters\ContactPresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @cover Timegridio\Concierge\Models\Contact
 */
class ContactTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateContact, CreateBusiness, CreateAppointment;

    /**
     * @test
     */
    public function it_belongs_to_a_user()
    {
        $user = $this->createUser();

        $contact = $this->createContact(['user_id' => $user->id]);

        $this->assertInstanceOf(BelongsTo::class, $contact->user());
        $this->assertInstanceOf(User::class, $contact->user()->first());
        $this->assertEquals($contact->user->id, $user->id);
    }

    /**
     * @test
     */
    public function it_belongs_to_a_business_addressbook()
    {
        $business = $this->createBusiness();

        $contact = $this->createContact();

        $business->contacts()->save($contact);

        $this->assertInstanceOf(BelongsToMany::class, $contact->businesses());
        $this->assertInstanceOf(Business::class, $contact->businesses()->first());
    }

    /**
     * @test
     */
    public function it_has_appointments()
    {
        $appointment = $this->createAppointment();

        $contact = $this->createContact();

        $contact->appointments()->save($appointment);

        $this->assertInstanceOf(HasMany::class, $contact->appointments());
        $this->assertInstanceOf(Appointment::class, $contact->appointments()->first());
    }

    /**
     * @test
     */
    public function it_checks_if_has_appointment()
    {
        $appointment = $this->createAppointment();

        $contact = $this->createContact();

        $contact->appointments()->save($appointment);

        $this->assertTrue($contact->hasAppointment());

        $contact->appointments()->delete();

        $this->assertFalse($contact->fresh()->hasAppointment());
    }

    /**
     * @test
     */
    public function it_uses_presenter()
    {
        $contact = $this->createContact();

        $presenter = $contact->getPresenterClass();

        $this->assertEquals(ContactPresenter::class, $presenter);
    }

    /**
     * @test
     */
    public function it_has_a_valid_mobile_number_or_null()
    {
        $contact = $this->createContact();

        $myNumber = '0034651464218';

        $contact->mobile = $myNumber;

        $this->assertEquals($myNumber, $contact->mobile);

        $myNumber = '';

        $contact->mobile = $myNumber;

        $this->assertNull($contact->mobile);
    }

    /**
     * @test
     */
    public function it_has_a_valid_mobile_country_or_null()
    {
        $contact = $this->createContact();

        $myNumber = 'US';

        $contact->mobile_country = $myNumber;

        $this->assertEquals($myNumber, $contact->mobile_country);

        $myNumber = '';

        $contact->mobile_country = $myNumber;

        $this->assertNull($contact->mobile_country);
    }

    /**
     * @test
     */
    public function it_has_a_valid_birthdate()
    {
        $contact = $this->createContact();

        // Provide Formatted String

        $contact->birthdate = '01/16/1985';

        $this->assertInstanceOf(Carbon::class, $contact->birthdate);
        $this->assertEquals('1985-01-16', $contact->birthdate->toDateString());

        // Provide Carbon Instance

        $contact->birthdate = Carbon::parse('01/16/1985');

        $this->assertInstanceOf(Carbon::class, $contact->birthdate);
        $this->assertEquals('1985-01-16', $contact->birthdate->toDateString());

        // Provide Empty String

        $contact->birthdate = '';

        $this->assertNull($contact->birthdate);
    }

    /**
     * @test
     */
    public function it_has_a_valid_email_or_null()
    {
        $contact = $this->createContact();

        // Provide Formatted String

        $contact->email = 'you.awesome@example.org';

        $this->assertEquals('you.awesome@example.org', $contact->email);

        // Provide Empty String

        $contact->email = '';

        $this->assertNull($contact->email);
    }

    /**
     * @test
     */
    public function it_determines_if_is_contact_of_given_user()
    {
        $user = $this->createUser();

        // Linked Profile

        $contact = $this->createContact(['user_id' => $user->id]);

        $this->assertTrue($contact->isProfileOf($user->id));

        // Unlinked Profile

        $contact->user()->dissociate()->save();

        $this->assertFalse($contact->fresh()->isProfileOf($user->id));
    }

    /**
     * @test
     */
    public function it_subscribes_to_a_business()
    {
        $business = $this->createBusiness();

        $contact = $this->createContact();

        $business->contacts()->save($contact);

        // Subscribed Profile

        $this->assertTrue($contact->isSubscribedTo($business->id));

        // UnSubscribed Profile

        $business->contacts()->detach();

        $this->assertFalse($contact->fresh()->isSubscribedTo($business->id));
    }


// DEPRECATED: autoLinkToUser removed from Contact model
//    /**
//     * @covers Timegridio\Concierge\Models\Contact::autoLinkToUser
//     * @test
//     */
//    public function it_does_not_link_to_existing_user_for_empty_email()
//    {
//        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);
//
//        $contact = $this->createContact(['email' => '']);
//
//        $contact->autoLinkToUser();
//
//        $this->assertNull($contact->user);
//    }

    //////////////////////
    // Extra Test Cases //
    //////////////////////

// DEPRECATED: autoLinkToUser removed from Contact model
//    /**
//     * @covers Timegridio\Concierge\Models\Contact::autoLinkToUser
//     * @test
//     */
//    public function it_links_to_existing_user()
//    {
//        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);
//
//        $contact = $this->createContact(['email' => 'guest@example.org']);
//
//        $contact->autoLinkToUser();
//
//        $this->assertEquals($user->email, $contact->user->email);
//    }

// DEPRECATED: autoLinkToUser removed from Contact model
//    /**
//     * @covers Timegridio\Concierge\Models\Contact::autoLinkToUser
//     * @test
//     */
//    public function it_links_another_to_existing_user()
//    {
//        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);
//
//        $contactFirst = $this->createContact(['email' => 'guest@example.org']);
//
//        $contactFirst->autoLinkToUser();
//
//        $this->assertEquals($user->email, $contactFirst->user->email);
//
//        $contactSecond = $this->createContact(['email' => 'guest@example.org']);
//
//        $contactSecond->autoLinkToUser();
//
//        $this->assertEquals($user->email, $contactSecond->user->email);
//
//        $this->assertEquals(2, $user->contacts()->count());
//    }

//    /**
//     * @covers Timegridio\Concierge\Models\Contact::autoLinkToUser
//     * @test
//     */
//    public function it_unlinks_removed_user()
//    {
//        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);
//
//        $contactFirst = $this->createContact(['email' => 'guest@example.org']);
//
//        $contactFirst->autoLinkToUser();
//
//        $this->assertEquals($user->email, $contactFirst->user->email);
//
//        $contactSecond = $this->createContact(['email' => 'guest@example.org']);
//
//        $contactSecond->autoLinkToUser();
//
//        $this->assertEquals($user->email, $contactSecond->user->email);
//
//        $user->email = 'changed@example.org';
//        $user->save();
//
//        $contactFirst->autoLinkToUser();
//        $contactSecond->autoLinkToUser();
//
//        $this->assertEquals(0, $user->contacts()->count());
//    }

    /**
     * @covers Timegridio\Concierge\Models\Contact::appointments
     * @test
     */
    public function it_gets_the_appointments()
    {
        $business = $this->createBusiness();

        $contact = $this->createContact();

        $appointment1 = factory(Appointment::class)->create([
            'business_id' => $business->id,
            'contact_id'  => $contact->id,
            'start_at'    => Carbon::now()->addDays(1),
            ]);
        $appointment2 = factory(Appointment::class)->create([
            'business_id' => $business->id,
            'contact_id'  => $contact->id,
            'start_at'    => Carbon::now()->addDays(2),
            ]);

        $this->assertCount(2, $contact->appointments);
    }

    /**
     * @covers Timegridio\Concierge\Models\Contact::getEmailAttribute
     * @test
     */
    public function it_gets_the_native_contact_email()
    {
        $business = $this->createBusiness();

        $email = 'test@example.org';

        $contact = $this->createContact(['email' => $email]);

        $this->assertEquals($email, $contact->email);
    }

    /**
     * @covers Timegridio\Concierge\Models\Contact::getEmailAttribute
     * @test
     */
    public function it_gets_the_native_contact_email_and_not_the_user_fallback()
    {
        $business = $this->createBusiness();

        $userFallbackEmail = 'tosto@example.org';
        $contactEmail = 'test@example.org';

        $user = $this->createUser(['email' => $userFallbackEmail]);

        $contact = $this->createContact([
            'email'   => $contactEmail,
            'user_id' => $user->id,
            ]);

        $this->assertEquals($contactEmail, $contact->email);
    }

    /**
     * @covers Timegridio\Concierge\Models\Contact::getEmailAttribute
     * @test
     */
    public function it_gets_the_user_fallback_contact_email()
    {
        $business = $this->createBusiness();

        $userFallbackEmail = 'tosto@example.org';
        $contactEmail = 'test@example.org';

        $user = $this->createUser(['email' => $userFallbackEmail]);

        $contact = $this->createContact([
            'email'   => null,
            'user_id' => $user->id,
            ]);

        $this->assertEquals($userFallbackEmail, $contact->email);
    }
}
