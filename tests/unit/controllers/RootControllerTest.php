<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

class RootControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * user.
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
        $this->visit(route('root.dashboard'));

        // Then I should see the Root access warning
        $this->seePageIs(route('root.dashboard'))
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
        $this->visit(route('root.dashboard'));

        // Then I should see the Root access warning
        $this->seePageIs('/home')
             ->dontSee('Registered Users');
    }

    /**
     * @covers   App\Http\Controllers\Root\RootController::getSudo
     * @test
     */
    public function it_sudoes_as_user()
    {
        // Given I am an authenticated user
        $root = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'root', 'slug' => 'root']);
        $root->assignRole('root');

        $user = factory(User::class)->create();

        // With the Root role
        $this->actingAs($root);

        // And I go to root dashboard
        $this->visit("/root/sudo/{$user->id}");

        // Then I should see the Root access warning
        $this->see('AUTHORIZED USE ONLY');
        $this->assertEquals($user->id, Auth::user()->id);
    }

    /**
     * @covers   App\Http\Controllers\Root\RootController::getSudo
     * @test
     */
    public function it_fails_sudoing_as_user()
    {
        // Given I am an authenticated user
        $nonRoot = factory(User::class)->create();

        $user = factory(User::class)->create();

        // With the Root role
        $this->actingAs($nonRoot);

        // And I go to root dashboard
        $this->visit("/root/sudo/{$user->id}");

        // Then I should see the Root access warning
        $this->dontSee('AUTHORIZED USE ONLY');
        $this->assertNotEquals($user->id, Auth::user()->id);
    }
}
