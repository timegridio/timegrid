<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerBusinessServiceControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateBusiness, CreateUser, CreateService;

    /**
     * @var App\Models\Business
     */
    protected $business;

    /**
     * @var App\Models\User
     */
    protected $owner;

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::index
     * @test
     */
    public function it_lists_the_business_services_for_management()
    {
        $this->arrangeBusinessWithOwner();

        $service = $this->makeService();

        $this->business->services()->save($service);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.service.index', $this->business));

        $this->assertResponseOk();
        $this->see('Add as many services as you provide to configure availability for each of them');
        $this->see($service->name);
    }

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::store
     * @test
     */
    public function it_stores_a_new_business_service()
    {
        $this->arrangeBusinessWithOwner();

        $service = $this->makeService();

        $this->actingAs($this->owner);

        $this->call('POST', route('manager.business.service.store', $this->business), $service->toArray());

        $this->assertCount(1, $this->business->fresh()->services);
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function arrangeBusinessWithOwner()
    {
        $this->owner = $this->createUser();

        $this->business = $this->createBusiness();

        $this->business->owners()->save($this->owner);
    }
}
