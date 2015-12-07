<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * user.
     *
     * @var User user
     */
    private $user;

    ///////////
    // TESTS //
    ///////////

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
        foreach ($businesses as $business) {
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
             ->see(substr($businesses[1]->description, 0, 10));
    }

    /** @test */
    public function it_presents_the_business_home_with_subscribe_button()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist some registered businesses
        $business = factory(Business::class)->create();
        // And which I am not subscribed

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
        $business = factory(Business::class)->create();
        // And which I am not subscribed

        // And I click one business
        $this->visit('/')->click('Browse')
            ->click($business->name)
            ->click('Subscribe');

        // Then I should see the subscription form
        $this->see('Fill your contact profile')
             ->see('My profile')
             ->see('save');
    }

    /** @test */
    public function it_lists_businesses_subscriptions()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        // And there exist a registered business
        $business = factory(Business::class)->create(['name' => 'tosto']);

        // And which I am subscribed as contact
        $contact = factory(Contact::class)->create();
        $contact->user()->associate($this->user);
        $contact->save();
        $business->contacts()->save($contact);

        // And I go to favourites (subscriptions) section
        $this->visit('/')->click('Favourites');

        // Then I should see the subscription list
        // and my profile (contact) firstname and last name
        // and the business slug i'm subscribed to
        $this->see('Subscriptions')
             ->see($contact->firstname)
             ->see($contact->lastname)
             ->see($business->slug);
    }

    ///////////////////////////
    // BUSINESS REGISTRATION //
    ///////////////////////////

    /** @test */
    public function it_registers_a_new_business_with_minimal_setup()
    {
        // Given I am an authenticated user
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);

        $business = factory(Business::class)->make(['name' => 'tosto']);

        // And I go to register a new Business
        $this->visit(route('manager.business.register'));

        // Then I should see the register business form
        $this->see('We are going to register your business with free plan')
             ->see('Register a business');

        // And I fill in the fields and submit
        $this->type($business->name, 'name')
             ->type($business->slug, 'slug')
             ->type($business->description, 'description')
             ->press('Register');

        // Then I should see the confirmation message
        $this->see('Business successfully registered');

        // Then I should see the registered business in database
        $this->seeInDatabase('businesses', ['name' => $business->name]);
        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }
}
