<?php

# use Laracasts\Integrated\Extensions\Selenium as IntegrationTest;

class ExampleTest extends TestCase {

    protected $baseUrl = 'http://localhost:8000';

    public function testRegistration()
    {
        $this->visit('/')
             ->click('Empecemos')
             ->see('Registrame')
             ->type('ariel', 'name')
             ->type('test@maildrop.cc', 'email')
             ->type('123123', 'password')
             ->type('123123', 'password_confirmation')
             ->press('Registrame')
             ->see('Muy bien');
    }
}