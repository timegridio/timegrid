<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagerBusinessServiceTypeControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateServiceType;

    /**
     * @var Timegridio\Concierge\Models\Business
     */
    protected $business;

    /**
     * @var App\Models\User
     */
    protected $owner;

    /**
     * @test
     */
    public function it_edits_service_types()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.servicetype.edit', $this->business));

        $this->assertResponseOk();
        $this->type('servicetype1:A description', 'servicetypes');
        $this->press('Update');
        $this->see('Service types were updated');
    }

    /**
     * @test
     */
    public function it_removes_all_service_types()
    {
        $this->arrangeBusinessWithOwner();

        $servicetype = $this->createServiceType([
            'business_id' => $this->business->id,
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.servicetype.edit', $this->business));

        $this->assertResponseOk();
        $this->see($servicetype->name);

        $this->type('', 'servicetypes');
        $this->press('Update');

        $this->see('Service types were updated');

        $this->visit(route('manager.business.servicetype.edit', $this->business));
        $this->dontSee($servicetype->name);
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
