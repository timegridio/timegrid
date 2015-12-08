<?php

use App\Models\Business;
use App\Models\Service;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $service;

    /**
     * @covers  App\Models\Service::scopeSlug
     * @test
     */
    public function it_scopes_by_slug()
    {
        $this->business = factory(Business::class)->create();
        $this->service = factory(Service::class)->make();

        $this->business->services()->save($this->service);

        $services = Service::slug($this->service->slug);
        $count = $services->count();
        $service = $services->first();

        /* Perform Test */
        $this->assertInstanceOf(Service::class, $service);
        $this->assertEquals($count, 1);
    }
}
