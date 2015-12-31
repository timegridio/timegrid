<?php

use App\Models\Business;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness;

    /** @test */
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
}
