<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @test
     */
    public function it_provides_successful_login()
    {
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);

        $this->visit('auth/login');

        $this->see('Login');
        $this->see('Password');
        $this->see('Remember me');

        $this->type($user->email, 'email');
        $this->type('password', 'password');

        $this->press('Login');

        $this->see('Well done! Please tell us what would you like to do');
    }

    /**
     * @test
     */
    public function it_denies_bad_login()
    {
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);

        $this->visit('auth/login');

        $this->see('Login');
        $this->see('Password');
        $this->see('Remember me');

        $this->type($user->email, 'email');
        $this->type('BAD PASSWORD!', 'password');

        $this->press('Login');

        $this->see('These credentials do not match our records');
    }

    /**
     * @test
     */
    public function it_requests_login_when_attempting_to_access_a_protected_page()
    {
        $this->visit(route('user.agenda'));

        $this->seePageIs('/auth/login');
        
        $this->see('Login');
        $this->see('Password');
        $this->see('Remember me');
    }
}
