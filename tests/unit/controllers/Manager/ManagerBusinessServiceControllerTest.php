<?php


class ManagerBusinessServiceControllerTest extends TestCase
{
    use CreateBusiness, CreateUser, CreateService;

    /**
     * @covers   App\Http\Controllers\Manager\BusinessServiceController::index
     * @test
     */
    public function it_lists_the_business_services_for_management()
    {
        $owner = $this->createUser();

        $business = $this->createBusiness();

        $business->owners()->save($owner);

        $service = $this->makeService();

        $business->services()->save($service);

        $this->actingAs($owner);

        $this->visit(route('manager.business.service.index', $business));

        $this->assertResponseOk();
        $this->see('Add as many services as you provide to configure availability for each of them');
        $this->see($service->name);
    }
}
