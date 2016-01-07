<?php

use Laracasts\Integrated\Extensions\Selenium as IntegrationTest;
use Laracasts\Integrated\Services\Laravel\DatabaseTransactions;

// use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserRegistrationProcessTest extends IntegrationTest
{
    use DatabaseTransactions;

    // protected $baseUrl = 'http://localhost:8000';

    protected function setLanguageAndGoToRegister()
    {
        return $this->visit('/lang/en_US.utf8')
             ->visit('/auth/register');
    }

    /** @test */
    public function testRegistrationSuccess()
    {
        $this->setLanguageAndGoToRegister()
             ->type('John', '#name')
             ->type('test@timegrid.io', '#email')
             ->type('password', '#password')
             ->type('password', '#password_confirmation')
             ->press('Register')
             ->see('I run a business');
    }

    /** @test */
    public function testRegistrationPasswordMissmatch()
    {
        $this->setLanguageAndGoToRegister()
             ->type('John', '#name')
             ->type('test@timegrid.io', '#email')
             ->type('password', '#password')
             ->type('wrong', '#password_confirmation')
             ->press('Register')
             ->see('Please confirm your password correctly');
    }
}
