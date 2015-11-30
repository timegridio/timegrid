<?php

use App\Business;
use App\Presenters\BusinessPresenter;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers            \App\Business::__construct
     * @test
     */
    public function test_it_creates_a_business()
    {
        $business = factory(Business::class)->create();

        return $business;
    }

   /**
     * @covers            \App\Business::__construct
     * @covers            \App\Business::save
     * @test
     */
    public function test_it_creates_a_business_that_appears_in_db()
    {
        $business = factory(Business::class)->create();

        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }

   /**
     * @covers            \App\Business::__construct
     * @covers            \App\Business::setSlugAttribute
     * @covers            \App\Business::save
     * @test@
     */
    public function test_it_generates_slug_from_name()
    {
        $business = factory(Business::class)->create();

        $slug = str_slug($business->name);

        $this->assertEquals($slug, $business->slug);
    }

   /**
     * @covers            \App\Business::getPresenter
     * @test
     */
    public function test_gets_business_presenter()
    {
        $business = factory(Business::class)->create();

        $businessPresenter = $business->getPresenter();

        $this->assertInstanceOf(BusinessPresenter::class, $businessPresenter);
    }

   /**
     * @covers            \App\Business::setPhoneAttribute
     * @test
     */
    public function test_sets_empty_phone_attribute()
    {
        $business = factory(Business::class)->make(['phone' => '']);

        $this->assertNull($business->phone);
    }

   /**
     * @covers            \App\Business::setPostalAddressAttribute
     * @test
     */
    public function test_sets_empty_postal_address_attribute()
    {
        $business = factory(Business::class)->make(['postal_address' => '']);

        $this->assertNull($business->postal_address);
    }
}
