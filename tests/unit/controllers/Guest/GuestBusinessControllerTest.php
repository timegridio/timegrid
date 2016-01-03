<?php

use App\Models\Business;
use App\Models\Domain;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GuestBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateBusiness;

    /**
     * @covers  \App\Http\Controllers\Guest\BusinessController::getHome
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
     * @covers  \App\Http\Controllers\Guest\BusinessController::getDomain
     * @test
     */
    public function it_presents_the_domain_home_with_a_single_business()
    {
        $owner = $this->createUser();
        $guest = $this->createUser();

        $businessOne = $this->makeBusiness($owner);

        $businessOne->save();

        $domain = Domain::create(['slug' => 'test-that-thang', 'owner_id' => $owner->id]);

        $this->actingAs($guest);

        $this->visit('/'.$domain->slug);

        $this->see($businessOne->name);
    }

    /**
     * @covers  \App\Http\Controllers\Guest\BusinessController::getDomain
     * @test
     */
    public function it_presents_the_domain_home_with_multiple_businesses()
    {
        $owner = $this->createUser();
        $guest = $this->createUser();

        $businessOne = $this->makeBusiness($owner);
        $businessTwo = $this->makeBusiness($owner);
        $businessThree = $this->makeBusiness($owner);

        $businessOne->save();
        $businessTwo->save();
        $businessThree->save();

        $domain = Domain::create(['slug' => 'test-that-thang', 'owner_id' => $owner->id]);

        $this->actingAs($guest);

        $this->visit('/'.$domain->slug);

        $this->see($businessOne->name);
        $this->see($businessTwo->name);
        $this->see($businessThree->name);
    }
}
