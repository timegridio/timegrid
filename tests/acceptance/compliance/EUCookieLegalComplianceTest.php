<?php

class EUCookieLegalComplianceTest extends TestCase
{
    const NOTICE = 'Your experience on this site will be improved by allowing cookies';
    const BUTTON = 'Allow cookies';

    /**
     * @test
     */
    public function it_displays_the_eu_cookie_notice()
    {
        config(['laravel-cookie-consent.enabled' => true]);

        $this->visit('/auth/login');
        $this->see(self::NOTICE);
        $this->see(self::BUTTON);
    }

    /**
     * @test
     */
    public function it_does_not_display_the_eu_cookie_notice_when_disabled()
    {
        config(['laravel-cookie-consent.enabled' => false]);

        $this->visit('/auth/login');
        $this->dontSee(self::NOTICE);
        $this->dontSee(self::BUTTON);
    }
}
