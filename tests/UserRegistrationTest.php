<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserRegistrationWithSuccess()
    {
        $this->visit('/')
             ->click('Empecemos')
             ->see('Registrame')
             ->type('ariel', 'name')
             ->type('alariva@gmail.com', 'email')
             ->type('123123', 'password')
             ->type('123123', 'password_confirmation')
             ->press('Registrame')
             ->see('Muy bien')
             ->assertEquals(true, \Auth::check());
    }

    public function testUserRegistrationWithFailure()
    {
        $this->visit('/')
             ->click('Empecemos')
             ->see('Registrame')
             ->type('ariel', 'name')
             ->type('alariva@gmail.com', 'email')
             ->type('123123', 'password')
             ->type('123124', 'password_confirmation')
             ->press('Registrame')
             ->assertEquals(false, \Auth::check());
    }
}