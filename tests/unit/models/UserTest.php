<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateRole;

    /** @test */
    public function it_creates_a_user_without_username()
    {
        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest'), 'username' => '']);

        $this->seeInDatabase('users', ['email' => $user->email, 'id' => $user->id]);
        $this->assertEquals(strlen($user->username), 32);
    }

    /** @test */
    public function it_creates_a_user_with_username()
    {
        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest'), 'username' => 'alariva']);

        $this->seeInDatabase('users', ['email' => $user->email, 'id' => $user->id, 'username' => $user->username]);
    }

    /** @test */
    public function it_assigns_a_role()
    {
        $user = $this->createUser();

        $role = $this->createRole();
        
        $user->assignRole($role->name);

        $this->assertCount(1, $user->roles);
    }
}
