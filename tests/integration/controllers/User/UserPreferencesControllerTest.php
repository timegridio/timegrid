<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserPreferencesControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateService;

    /**
     * @test
     */
    public function it_shows_the_user_preferences_page()
    {
        $this->actingAs($this->createUser());

        $this->visit(route('user.preferences'));

        $this->assertResponseOk();
        $this->see('Preferences');
    }

    /**
     * @test
     */
    public function it_updates_the_user_preferences()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $assertInDatabase = [
            'preferenceable_id'   => $user->id,
            'preferenceable_type' => User::class,
            'key'                 => 'timezone',
            'value'               => 'Europe/Rome',
            ];

        $this->dontSeeInDatabase('preferences', $assertInDatabase);

        $data = [
            'timezone' => 'Europe/Rome',
            ];

        $this->call('POST', route('user.preferences'), $data);

        $this->seeInDatabase('preferences', $assertInDatabase);
    }
}
