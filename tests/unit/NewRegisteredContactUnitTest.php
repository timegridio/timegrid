<?php

use App\Models\User;
use App\Models\Contact;
use App\Events\NewRegisteredContact;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewRegisteredContactUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers App\Events\NewRegisteredContact::__construct
     * @covers App\Handlers\Events\LinkContactToExistingUser::handle
     * @test
     */
    public function it_fires_NewRegisteredContact_event_and_links_user()
    {
        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest')]);

        $contact = $this->createContact(['email' => 'guest@example.org']);

        event(new NewRegisteredContact($contact));

        $this->seeInDatabase('contacts', ['email' =>$user->email, 'user_id' => $user->id]);
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
