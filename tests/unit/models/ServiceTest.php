<?php

use App\Models\Service;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateService;

    /**
     * @covers  App\Models\Service::scopeSlug
     * @test
     */
    public function it_scopes_by_slug()
    {
        $business = $this->createBusiness();
        $service = $this->makeService();

        $business->services()->save($service);

        $services = Service::slug($service->slug);
        $count = $services->count();
        $service = $services->first();

        /* Perform Test */
        $this->assertInstanceOf(Service::class, $service);
        $this->assertEquals($count, 1);
    }
}
