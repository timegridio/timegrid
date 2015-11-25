<?php

use Laracasts\Integrated\Extensions\Selenium as IntegrationTest;

# use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends IntegrationTest
{
    # use DatabaseTransactions;

    # protected $baseUrl = 'http://localhost:8000';
    protected function setLanguageAndLogin()
    {
        return $this->visit('/lang/en_US.utf8')
                    ->visit('/auth/login')
                    ->type('alariva@timegrid.io', '#email')
                    ->type('password', '#password')
                    ->press('Login')
                    ->waitForElement('navProfile');
    }

    /** @test */
    public function testBrowseDirectory()
    {
        $this->setLanguageAndLogin()
             ->click('Businesses')
             ->click('Browse')
             ->see('Available businesses');
    }

    /** @test */
    public function testMyReservationsIsEmpty()
    {
        $this->setLanguageAndLogin()
             ->click('Businesses')
             ->click('My Reservations')
             ->see('You have no ongoing reservations by now');
    }
}
