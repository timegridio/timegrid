<?php

class WelcomeControllerTest extends TestCase
{
    /** @test */
    public function it_presents_the_welcome_page()
    {
        // Given I am a not authenticated user (guest)

        // And I visit the homepage
        $this->visit('/');

        // Then I should see the jumbotron presentation
        $this->see('The booking app for successful professionals')
             ->see('Let\'s begin')
             ->see('Login');
    }

   /** @test */
    public function it_presents_the_login_page()
    {
        // Given I am a not authenticated user (guest)

        // And I visit the homepage
        $this->visit('/');
        // And I click the Login button
        $this->click('Login');

        // Then I should see the login form
        $this->see('Login')    // Form header
             ->see('Email')    // Login Form field
             ->see('Password') // Login Form field
             ->see('Github')   // oAuth button
             ->see('Facebook') // oAuth button
             ->see('Google');  // oAuth button
    }

    /** @test */
    public function it_presents_the_register_page()
    {
        // Given I am a not authenticated user (guest)

        // And I visit the homepage
        $this->visit('/');
        // And I click the Login button
        $this->click('Let\'s begin');

        // Then I should see the register form
        $this->see('We are going to build your profile') // Form header
             ->see('Your Email')      // Login Form field
             ->see('A password')      // Login Form field
             ->see('Repeat password') // Login Form field
             ->see('Register');       // Submit button
    }

    /** @test */
    public function it_presents_the_register_page_through_login()
    {
        // Given I am a not authenticated user (guest)

        // And I visit the homepage
        $this->visit('/auth/login');
        // And I click the Login button
        $this->click('Not registered yet');

        // Then I should see the register form
        $this->see('We are going to build your profile') // Form header
             ->see('Your Email')      // Login Form field
             ->see('A password')      // Login Form field
             ->see('Repeat password') // Login Form field
             ->see('Register');       // Submit button
    }
}
