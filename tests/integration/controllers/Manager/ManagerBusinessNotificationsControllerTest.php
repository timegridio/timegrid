<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerBusinessNotificationsControllerTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateBusiness;

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
    public function it_displays_the_notifications_board()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.notifications.show', $this->business));

        $this->seePageIs($this->business->slug.'/manage/notifications');
        $this->see('Recently');

        // TODO: Assert some sample notifications
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
