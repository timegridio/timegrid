<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @covers App\Models\Contact::autoLinkToUser
     * @test
     */
    public function it_links_to_existing_user()
    {
        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);

        $contact = $this->createContact(['email' => 'guest@example.org']);

        $contact->autoLinkToUser();

        $this->assertEquals($user->email, $contact->user->email);
    }

    /**
     * @covers App\Models\Contact::autoLinkToUser
     * @test
     */
    public function it_links_another_to_existing_user()
    {
        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);

        $contactFirst = $this->createContact(['email' => 'guest@example.org']);

        $contactFirst->autoLinkToUser();

        $this->assertEquals($user->email, $contactFirst->user->email);

        $contactSecond = $this->createContact(['email' => 'guest@example.org']);

        $contactSecond->autoLinkToUser();

        $this->assertEquals($user->email, $contactSecond->user->email);

        $this->assertEquals(2, $user->contacts()->count());
    }

    /**
     * @covers App\Models\Contact::autoLinkToUser
     * @test
     */
    public function it_unlinks_removed_user()
    {
        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);

        $contactFirst = $this->createContact(['email' => 'guest@example.org']);

        $contactFirst->autoLinkToUser();

        $this->assertEquals($user->email, $contactFirst->user->email);

        $contactSecond = $this->createContact(['email' => 'guest@example.org']);

        $contactSecond->autoLinkToUser();

        $this->assertEquals($user->email, $contactSecond->user->email);

        $user->email = 'changed@example.org';
        $user->save();

        $contactFirst->autoLinkToUser();
        $contactSecond->autoLinkToUser();

        $this->assertEquals(0, $user->contacts()->count());
    }

    /**
     * @covers App\Models\Contact::appointments
     * @test
     */
    public function it_gets_the_appointments()
    {
        $business = factory(Business::class)->create();

        $contact = $this->createContact();

        $appointment1 = factory(Appointment::class)->create([
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'start_at' => Carbon::now()->addDays(1),
            ]);
        $appointment2 = factory(Appointment::class)->create([
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'start_at' => Carbon::now()->addDays(2),
            ]);

        $this->assertCount(2, $contact->appointments);
    }

    /**
     * @covers App\Models\Contact::getEmailAttribute
     * @test
     */
    public function it_gets_the_native_contact_email()
    {
        $business = factory(Business::class)->create();

        $email = 'test@example.org';

        $contact = $this->createContact(['email' => $email]);

        $this->assertEquals($email, $contact->email);
    }

    /**
     * @covers App\Models\Contact::getEmailAttribute
     * @test
     */
    public function it_gets_the_native_contact_email_and_not_the_user_fallback()
    {
        $business = factory(Business::class)->create();

        $userFallbackEmail = 'tosto@example.org';
        $contactEmail = 'test@example.org';

        $user = $this->createUser(['email' => $userFallbackEmail]);

        $contact = $this->createContact([
            'email' => $contactEmail,
            'user_id' => $user->id
            ]);

        $this->assertEquals($contactEmail, $contact->email);
    }

    /**
     * @covers App\Models\Contact::getEmailAttribute
     * @test
     */
    public function it_gets_the_user_fallback_contact_email()
    {
        $business = factory(Business::class)->create();

        $userFallbackEmail = 'tosto@example.org';
        $contactEmail = 'test@example.org';

        $user = $this->createUser(['email' => $userFallbackEmail]);

        $contact = $this->createContact([
            'email' => null,
            'user_id' => $user->id
            ]);

        $this->assertEquals($userFallbackEmail, $contact->email);
    }

    /////////////
    // HELPERS //
    /////////////

    private function createUser($overrides = [])
    {
        $user = factory(User::class)->create($overrides);

        return $user;
    }

    private function createContact($overrides = [])
    {
        $contact = factory(Contact::class)->create($overrides);

        return $contact;
    }
}
