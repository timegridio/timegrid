<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessUnitTest extends TestCase
{
    use DatabaseTransactions;

    public function testBusinessCreationWithSuccess()
    {
        $business = factory(App\Business::class)->create();

        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }

    public function testBusinessPresenter()
    {
        $business = factory(App\Business::class)->create();

        $businessPresenter = $business->getPresenter();
    }
}
