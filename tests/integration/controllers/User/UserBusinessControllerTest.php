<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class UserBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment, CreateService;

    /**
     * @test
     */
    public function it_presents_the_businesses_listing()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $this->visit('/home')->click('Browse');

        $this->see('Available businesses');
    }

    /**
     * @test
     */
    public function it_lists_some_businesses()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $businesses = $this->createBusinesses(30);

        $this->visit('/home')->click('Browse');

        foreach ($businesses as $business) {
            $this->see(substr($business->name, 0, 50)); /* Up to 50 chars */
        }
    }

    /**
     * @test
     */
    public function it_presents_the_business_home()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $businesses = $this->createBusinesses(15);

        $this->visit('/home')->click('Browse')
             ->click($businesses[1]->name);

        $this->see($businesses[1]->name)
             ->see(substr($businesses[1]->description, 0, 10));
    }

    /**
     * @test
     */
    public function it_presents_the_business_home_with_subscribe_button()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness();

        $this->visit('/home')->click('Browse')
            ->click($business->name);

        $this->see($business->name)
             ->see('subscribe');
    }

    /**
     * @test
     */
    public function it_presents_the_business_subscription_form()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness();

        $this->visit('/home')->click('Browse')
            ->click($business->name)
            ->click('Subscribe');

        $this->see('Fill your contact profile')
             ->see('My profile')
             ->see('save');
    }

    /**
     * @test
     */
    public function it_lists_businesses_subscriptions()
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $business = $this->createBusiness(['name' => 'tosto']);

        $contact = $this->makeContact($user);

        $business->contacts()->save($contact);

        $this->visit('/home')->click('Subscriptions');

        $this->see('Subscriptions')
             ->see($contact->firstname)
             ->see($contact->lastname)
             ->see($business->slug);
    }

    ///////////////////////////
    // BUSINESS REGISTRATION //
    ///////////////////////////

    /**
     * @test
     */
    public function it_registers_a_new_business_with_minimal_setup()
    {
        $ownerUser = $this->createUser();
        $this->actingAs($ownerUser);

        $business = $this->makeBusiness($ownerUser, ['name' => 'tosto']);

        $this->visit(route('manager.business.register'));

        $this->see('We are going to register your business with free plan')
             ->see('Register a business');

        $this->type($business->name, 'name')
             ->type($business->description, 'description')
             ->press('Register');

        $this->see('Business successfully registered');

        $this->seeInDatabase('businesses', ['name' => $business->name]);
        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }
}
