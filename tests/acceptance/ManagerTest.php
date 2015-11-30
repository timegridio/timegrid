<?php

use Laracasts\Integrated\Extensions\Selenium;
use Laracasts\Integrated\Services\Laravel\Application as Laravel;

class ManagerTest extends Selenium
{
    use Laravel;

    /**
     * set Language And Login
     */
    protected function setLanguageAndLogin()
    {
        return $this->visit('/lang/en_US.utf8')
                    ->visit('/auth/login')
                    ->type('demo@timegrid.io', '#email')
                    ->type('demomanager', '#password')
                    ->press('Login')
                    ->waitForElement('navProfile');
    }

    ///////////
    // TESTS //
    ///////////

    /** @test */
    public function it_opens_the_dashboard()
    {
        $this->setLanguageAndLogin()
             ->see('Demo Venue');
    }

    /** @test */
    public function it_opens_the_vacancies_section()
    {
        $this->setLanguageAndLogin()
             ->see('Dashboard')
             ->waitForElement('btnVacancies')
             ->click('btnVacancies')
             ->see('Availability');
    }

    /** @test */
    public function it_opens_the_preferences_section()
    {
        $this->setLanguageAndLogin()
             ->waitForElement('btnPreferences')
             ->click('btnPreferences')
             ->see('Business preferences');
    }

    /** @test */
    public function it_opens_the_agenda_section()
    {
        $this->setLanguageAndLogin()
             ->waitForElement('btnAgenda')
             ->click('btnAgenda')
             ->see('Code');
    }

    /** @test */
    public function it_opens_the_services_section()
    {
        $this->setLanguageAndLogin()
             ->waitForElement('btnServices')
             ->click('btnServices')
             ->see('Services')
             ->see('Add a service')
             ->see('set and publish my availability');
    }
}
