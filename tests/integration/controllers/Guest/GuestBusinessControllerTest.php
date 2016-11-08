<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Business;

class GuestBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateBusiness, CreateDomain;

    /**
     * @test
     */
    public function it_presents_the_business_home()
    {
        // Given I am a guest user
        $business = $this->createBusiness();

        // And I visit the homepage
        $this->visit(route('guest.business.home', $business));

        // Then I should see the business home
        $this->see($business->name)
             ->see(substr($business->description, 0, 15));
    }

    /**
     * @test
     */
    public function it_presents_the_domain_home_with_a_single_business_to_user()
    {
        $owner = $this->createUser();
        $user = $this->createUser();

        $businessOne = $this->makeBusiness($owner);

        $businessOne->save();

        $domain = $this->createDomain(['slug' => 'test-that-thang', 'owner_id' => $owner->id]);

        $this->actingAs($user);

        $this->visit('/'.$domain->slug);

        $this->see($businessOne->name);
    }

    /**
     * @test
     */
    public function it_presents_the_domain_home_with_multiple_businesses_to_user()
    {
        $owner = $this->createUser();
        $user = $this->createUser();

        $businessOne = $this->makeBusiness($owner);
        $businessTwo = $this->makeBusiness($owner);
        $businessThree = $this->makeBusiness($owner);

        $businessOne->save();
        $businessTwo->save();
        $businessThree->save();

        $domain = $this->createDomain(['slug' => 'test-that-thang', 'owner_id' => $owner->id]);

        $this->actingAs($user);

        $this->visit('/'.$domain->slug);

        $this->see($businessOne->name);
        $this->see($businessTwo->name);
        $this->see($businessThree->name);
    }

    /**
     * @test
     */
    public function it_presents_the_domain_home_with_multiple_businesses_to_guest()
    {
        $owner = $this->createUser();

        $businessOne = $this->makeBusiness($owner);
        $businessTwo = $this->makeBusiness($owner);
        $businessThree = $this->makeBusiness($owner);

        $businessOne->save();
        $businessTwo->save();
        $businessThree->save();

        $domain = $this->createDomain(['slug' => 'test-that-thang', 'owner_id' => $owner->id]);

        $this->visit('/'.$domain->slug);

        $this->see($businessOne->name);
        $this->see($businessTwo->name);
        $this->see($businessThree->name);
    }

    /**
     * @test
     */
    public function it_resumes_the_last_visited_business_as_guest_after_registration()
    {
        $business = $this->createBusiness();
        $user = $this->createUser();

        $this->visit('/'.$business->slug);
        $this->visit('register');
        $this->type('test', 'name');
        $this->type('test@example.org', 'email');
        $this->type('aPassword', 'password');
        $this->type('aPassword', 'password_confirmation');
        $this->press('Register');
        $this->seePageIs('/'.$business->slug);

        $this->visit('register');
        $this->seePageIs('/'.$business->slug);
    }

    /**
     * @test
     */
    public function it_displays_available_name_when_business_does_not_exist()
    {
        $this->visit('/this-name-is-not-registered');

        $this->see('name is available. Register it now');
    }
}
