<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @covers  App\Http\Controllers\Manager\BusinessServiceController
 */
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

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::show
     * @test
     */
    public function it_shows_the_business_service_page_for_management()
    {
        $this->arrangeBusinessWithOwner();

        $service = $this->makeService();

        $this->business->services()->save($service);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.service.show', ['business' => $this->business, 'service' => $service]));

        $this->assertResponseOk();
        $this->see($service->name);
        $this->see($service->slug);
        $this->see($service->description);
    }

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::edit
     * @test
     */
    public function it_shows_the_business_service_edit_page_for_management()
    {
        $this->arrangeBusinessWithOwner();

        $service = $this->makeService();

        $this->business->services()->save($service);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.service.edit', ['business' => $this->business, 'service' => $service]));

        $this->assertResponseOk();
        $this->see($service->name);
        $this->see($service->color);
        $this->see($service->description);
    }

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::update
     * @test
     */
    public function it_updates_the_business_service()
    {
        $this->arrangeBusinessWithOwner();

        $service = $this->makeService();

        $this->business->services()->save($service);

        $this->actingAs($this->owner);

        $service->name = 'New Name';

        $this->call('PUT', route('manager.business.service.update', [
            'business' => $this->business,
            'service' => $service]),
            $service->toArray()
            );

        $this->assertEquals($service->name, $this->business->fresh()->services()->whereId($service->id)->first()->name);
    }

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::destroy
     * @test
     */
    public function it_removes_the_business_service()
    {
        $this->arrangeBusinessWithOwner();

        $service = $this->makeService();

        $this->business->services()->save($service);

        $this->assertCount(1, $this->business->fresh()->services);

        $this->actingAs($this->owner);

        $this->call('DELETE', route('manager.business.service.destroy', [
            'business' => $this->business,
            'service' => $service])
            );

        $this->assertCount(0, $this->business->fresh()->services);
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
