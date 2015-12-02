<?php

use App\Models\User;
use App\Models\Business;

class UserBusinessControllerTest extends TestCase
{
    private $user;

    /** @test */
    public function it_presents_the_businesses_listing()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And I visit the homepage
        $this->visit('/')->click('Browse');

        // Then I should see the listing header
        $this->see('Available businesses');
    }

    /** @test */
    public function it_lists_some_businesses()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        // And there exist some registered businesses
        $businesses = factory(Business::class, 30)->create();

        // And I visit the homepage
        $this->visit('/')->click('Browse');

        // And I should see each of the businesses by their name
        foreach($businesses as $business)
        {
            $this->see($business->name);
        }
    }

    /** @test */
    public function it_presents_the_business_home()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        // And there exist some registered businesses
        $businesses = factory(Business::class, 15)->create();

        // And I click the business
        $this->visit('/')->click('Browse')
            ->click($businesses[1]->name);

        // Then I should see the business homepage
        $this->see($businesses[1]->name)
             ->see($businesses[1]->description);
    }

    /** @test */
    public function it_presents_the_business_home_with_subscribe_button()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        // And there exist some registered businesses
        // And which I am not subscribed
        $business = factory(Business::class)->create();

        // And I click one business
        $this->visit('/')->click('Browse')
            ->click($business->name);

        // Then I should see the business homepage and the subscribe button
        $this->see($business->name)
             ->see('subscribe');
    }

    /** @test */
    public function it_presents_the_business_subscription_form()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
        // And there exist some registered businesses
        // And which I am not subscribed
        $business = factory(Business::class)->create();

        // And I click one business
        $this->visit('/')->click('Browse')
            ->click($business->name)
            ->click('Subscribe');

        // Then I should see the subscription form
        $this->see('Fill your contact profile')
             ->see('My profile')
             ->see('save');
    }
}
