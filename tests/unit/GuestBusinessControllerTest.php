<?php

use App\Models\Business;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;

    ///////////
    // TESTS //
    ///////////

    /** @test */
    public function it_presents_the_business_home()
    {
        // Given I am a guest user
        $business = factory(Business::class)->create();

        // And I visit the homepage
        $this->visit("/about/{$business->id}");

        // Then I should see the business home
        $this->see($business->name)
             ->see($business->description);
    }
}
