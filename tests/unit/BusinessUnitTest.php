<?php

use App\Business;
use App\Presenters\BusinessPresenter;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BusinessUnitTest extends TestCase
{
    use DatabaseTransactions;

   /**
     * @covers            \App\Business::__construct
     */
    public function testCreateBusiness()
    {
        $business = factory(Business::class)->create();

        return $business;
    }

   /**
     * @covers            \App\Business::__construct
     * @covers            \App\Business::save
     */
    public function testCreateAndSeeBusinessStoredInDatabase()
    {
        $business = factory(Business::class)->create();

        $this->seeInDatabase('businesses', ['slug' => $business->slug]);

        return $business;
    }

   /**
     * @covers            \App\Business::getPresenter
     * @depends           testCreateBusiness
     */
    public function testBusinessGetPresenter(Business $business)
    {
        $businessPresenter = $business->getPresenter();

        $this->assertInstanceOf(BusinessPresenter::class, $businessPresenter);
    }

   /**
     * @covers            \App\Business::setPhoneAttribute
     * @depends           testCreateBusiness
     */
    public function testSetEmptyPhoneAttributeGetsNull(Business $business)
    {
        $business->phone = '';

        $this->assertNull($business->phone);
    }

   /**
     * @covers            \App\Business::setPostalAddressAttribute
     * @depends           testCreateBusiness
     */
    public function testSetEmptyPostalAddressAttributeGetsNull(Business $business)
    {
        $business->postal_address = '';

        $this->assertNull($business->postal_address);
    }
}
