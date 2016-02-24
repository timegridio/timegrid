<?php

use Timegridio\Concierge\Models\Business;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GuestBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
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
}
