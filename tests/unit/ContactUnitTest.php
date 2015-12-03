<?php

use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers App\Models\Contact::autoLinkToUser
     * @test
     */
    public function test_it_links_to_existing_user()
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
    public function test_it_links_another_to_existing_user()
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
    public function test_it_unlinks_removed_user()
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
