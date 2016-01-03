<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @covers  \App\Http\Controllers\Auth\AuthController@getLogin
     * @covers  \App\Http\Controllers\Auth\AuthController@postLogin
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
     * @covers  \App\Http\Controllers\Auth\AuthController@getLogin
     * @covers  \App\Http\Controllers\Auth\AuthController@postLogin
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
}
