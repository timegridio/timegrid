<?php

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @covers  App\Http\Controllers\Root\RootController
 */
class RootControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @covers   App\Http\Controllers\Root\RootController::getIndex
     * @test
     */
    public function it_gets_to_root_dashboard()
    {
        // Given I am an authenticated user
        $user = $this->createUser();
        $role = factory(Role::class)->create(['name' => 'root', 'slug' => 'root']);
        $user->assignRole('root');

        // With the Root role
        $this->actingAs($user);

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
        $user = $this->createUser();

        // With the Root role
        $this->actingAs($user);

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
        $root = $this->createUser();
        $role = factory(Role::class)->create(['name' => 'root', 'slug' => 'root']);
        $root->assignRole('root');

        $user = $this->createUser();

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
    public function it_prevents_unauthorized_sudo()
    {
        // Given I am an authenticated user
        $nonRoot = $this->createUser();

        $user = $this->createUser();

        // With the Root role
        $this->actingAs($nonRoot);

        // And I go to root dashboard
        $this->visit("/root/sudo/{$user->id}");

        // Then I should see the Root access warning
        $this->dontSee('AUTHORIZED USE ONLY');
        $this->assertNotEquals($user->id, Auth::user()->id);
    }
}
