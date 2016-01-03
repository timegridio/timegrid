<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegisterTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * @covers  \App\Http\Controllers\Auth\AuthController@getRegister
     * @covers  \App\Http\Controllers\Auth\AuthController@postRegister
     * @test
     */
    public function it_provides_successful_registration()
    {
        $user = $this->makeUser();

        $this->visit('auth/register');

        $this->seeRegistrationFormFields();

        $this->type($user->name, 'name');
        $this->type($user->username, 'username');
        $this->type($user->email, 'email');
        $this->type('password', 'password');
        $this->type('password', 'password_confirmation');

        $this->press('Register');

        $this->see('Well done! Please tell us what would you like to do');
    }

    /**
     * @covers  \App\Http\Controllers\Auth\AuthController@getRegister
     * @covers  \App\Http\Controllers\Auth\AuthController@postRegister
     * @test
     */
    public function it_denies_no_password_registration()
    {
        $user = $this->makeUser();

        $this->visit('auth/register');

        $this->seeRegistrationFormFields();

        $this->type($user->name, 'name');
        $this->type($user->username, 'username');
        $this->type($user->email, 'email');

        $this->press('Register');

        $this->see('The password field is required.');
    }

    /////////////
    // Helpers //
    /////////////

    protected function seeRegistrationFormFields()
    {
        $this->see('Hi! We are going to build your profile');
        $this->see('Your name');
        $this->see('Username');
        $this->see('Your Email');
        $this->see('A password');
        $this->see('Repeat password');

        $this->see('Register');
    }

}
