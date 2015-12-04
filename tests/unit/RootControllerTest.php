<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RootControllerTest extends TestCase
{
    use DatabaseTransactions;
 
    /**
     * user
     *
     * @var User user
     */
    private $user;

    ///////////
    // TESTS //
    ///////////

    /**
     * @covers   App\Http\Controllers\Root\RootController::getIndex
     * @test
     */
    public function it_gets_to_root_dashboard()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root', 'slug' => 'root']);
        $this->user->assignRole('root');

        // With the Root role
        $this->actingAs($this->user);

        // And I go to root dashboard
        $this->visit('/root/dashboard');

        // Then I should see the Root access warning
        $this->seePageIs('/root/dashboard')
             ->see('Registered Users');
    }

    /**
     * @covers   App\Http\Controllers\Root\RootController::getIndex
     * @test
     */
    public function it_rejects_root_dashboard_to_unauthorized()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();

        // With the Root role
        $this->actingAs($this->user);

        // And I go to root dashboard
        $this->visit('/root/dashboard');

        // Then I should see the Root access warning
        $this->seePageIs('/home')
             ->dontSee('Registered Users');
    }
}
