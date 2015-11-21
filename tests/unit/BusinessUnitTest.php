<?php

use App\Business;
use App\Presenters\BusinessPresenter;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers            \App\Business::create
     */
    public function testCreatedBusinessGetsStoredInDatabase()
    {
        $business = factory(Business::class)->create();

        $this->seeInDatabase('businesses', ['slug' => $business->slug]);
    }

   /**
     * @covers            \App\Business::getPresenter
     */
    public function testBusinessGetPresenter()
    {
        $business = factory(Business::class)->create();

        $businessPresenter = $business->getPresenter();

        $this->assertInstanceOf(BusinessPresenter::class, $businessPresenter);
    }

   /**
     * @covers            \App\Business::setPhoneAttribute
     */
    public function testSetEmptyPhoneAttributeGetsNull()
    {
        $business = factory(Business::class)->create();

        $business->phone = '';

        $this->assertNull($business->phone);
    }

   /**
     * @covers            \App\Business::setPostalAddressAttribute
     */
    public function testSetEmptyPostalAddressAttributeGetsNull()
    {
        $business = factory(Business::class)->create();

        $business->postal_address = '';

        $this->assertNull($business->postal_address);
    }
}
