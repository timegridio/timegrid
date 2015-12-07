<?php

use App\Models\Business;
use App\Presenters\BusinessPresenter;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @covers            \App\Models\Business::__construct
     * @test
     */
    public function test_it_creates_a_business()
    {
        $business = factory(Business::class)->create();

        return $business;
    }

    /**
     * @covers            \App\Models\Business::__construct
     * @covers            \App\Models\Business::save
     * @test
     */
    public function test_it_creates_a_business_that_appears_in_db()
    {
        $business = factory(Business::class)->create();

        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }

    /**
     * @covers            \App\Models\Business::__construct
     * @covers            \App\Models\Business::setSlugAttribute
     * @covers            \App\Models\Business::save
     * @test@
     */
    public function test_it_generates_slug_from_name()
    {
        $business = factory(Business::class)->create();

        $slug = str_slug($business->name);

        $this->assertEquals($slug, $business->slug);
    }

    /**
     * @covers            \App\Models\Business::getPresenterClass
     * @test
     */
    public function test_gets_business_presenter()
    {
        $business = factory(Business::class)->create();

        $businessPresenter = $business->getPresenterClass();

        $this->assertSame(BusinessPresenter::class, $businessPresenter);
    }

    /**
     * @covers            \App\Models\Business::setPhoneAttribute
     * @test
     */
    public function test_sets_empty_phone_attribute()
    {
        $business = factory(Business::class)->make(['phone' => '']);

        $this->assertNull($business->phone);
    }

    /**
     * @covers            \App\Models\Business::setPostalAddressAttribute
     * @test
     */
    public function test_sets_empty_postal_address_attribute()
    {
        $business = factory(Business::class)->make(['postal_address' => '']);

        $this->assertNull($business->postal_address);
    }
}
