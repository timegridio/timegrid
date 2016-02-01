<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerBusinessControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
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
    public function it_displays_the_unique_existing_business_dashboard()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.index'));

        $this->seePageIs('biz/'.$this->business->slug.'/manage/dashboard');
        $this->see('You only have one business registered. Here your dashboard');
    }

    /**
     * @test
     */
    public function it_displays_the_business_listing()
    {
        $this->owner = $this->createUser();

        $businessOne = $this->createBusiness();
        $businessTwo = $this->createBusiness();

        $businessOne->owners()->save($this->owner);
        $businessTwo->owners()->save($this->owner);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.index'));

        $this->seePageIs('/user/businesses');
        $this->see('From here you can manage all your businesses');
        $this->see($businessOne->name);
        $this->see($businessTwo->name);
    }

    /**
     * @test
     */
    public function it_stores_a_business_registration()
    {
        $this->owner = $this->createUser();

        $businessData = [
            'name'        => 'Tosto',
            'slug'        => 'tosto',
            'category'    => '1',
            'description' => 'Tosto this tosti to say',
            'locale'      => 'en_US.utf8',
            'strategy'    => 'dateslot',
        ];

        $this->assertCount(0, $this->owner->fresh()->businesses);

        $this->actingAs($this->owner);

        $this->call('POST', route('manager.business.store'), $businessData);

        $this->assertCount(1, $this->owner->fresh()->businesses);
    }

    /**
     * @test
     */
    public function it_prevents_a_duplicated_business_registration()
    {
        $this->owner = $this->createUser();

        $businessData = [
            'name'        => 'Tosto',
            'slug'        => 'tosto',
            'category'    => '1',
            'description' => 'Tosto this tosti to say',
            'locale'      => 'en_US.utf8',
            'strategy'    => 'dateslot',
        ];

        $this->assertCount(0, $this->owner->fresh()->businesses);

        $this->actingAs($this->owner);

        $this->call('POST', route('manager.business.store'), $businessData);

        $this->assertCount(1, $this->owner->fresh()->businesses);

        $this->call('POST', route('manager.business.store'), $businessData);

        $this->assertCount(1, $this->owner->fresh()->businesses);
    }

    /**
     * @test
     */
    public function it_prevents_registering_an_existing_business_slug()
    {
        $ownerOne = $this->createUser();

        $ownerTwo = $this->createUser();

        $businessDataOne = [
            'name'        => 'Tosto',
            'slug'        => 'tosto',
            'category'    => '1',
            'description' => 'Tosto this tosti to say',
            'locale'      => 'en_US.utf8',
            'strategy'    => 'dateslot',
        ];

        $businessDataTwo = [
            'name'        => 'Tosto',
            'slug'        => 'tosto',
            'category'    => '2',
            'description' => 'This some other business',
            'locale'      => 'en_US.utf8',
            'strategy'    => 'timeslot',
        ];

        $this->assertCount(0, $ownerOne->fresh()->businesses);

        $this->actingAs($ownerOne);

        $this->call('POST', route('manager.business.store'), $businessDataOne);

        $this->assertCount(1, $ownerOne->fresh()->businesses);

        $this->actingAs($ownerTwo);

        $this->call('POST', route('manager.business.store'), $businessDataTwo);

        $this->assertCount(0, $ownerTwo->fresh()->businesses);
    }

    /**
     * @test
     */
    public function it_prevents_storing_a_duplicated_business_registration()
    {
        $this->owner = $this->createUser();

        $businessData = [
            'name'        => 'Tosto',
            'slug'        => 'tosto',
            'category'    => '1',
            'description' => 'Tosto this tosti to say',
            'locale'      => 'en_US.utf8',
            'strategy'    => 'dateslot',
        ];

        $this->assertCount(0, $this->owner->fresh()->businesses);

        $this->actingAs($this->owner);

        $this->call('POST', route('manager.business.store'), $businessData);

        $this->assertCount(1, $this->owner->fresh()->businesses);

        // Attempt a duplicated registration
        $this->call('POST', route('manager.business.store'), $businessData);

        $this->assertCount(1, $this->owner->fresh()->businesses);
    }

    /**
     * @test
     */
    public function it_displays_the_business_edit_page()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.edit', $this->business));

        $this->seePageIs('biz/'.$this->business->slug.'/manage/edit');
        $this->see('Business profile edit');
    }

    /**
     * @test
     */
    public function it_updates_the_business_profile()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->business->description = 'A new description';

        $this->call('PUT', route('manager.business.update', $this->business), $this->business->toArray());

        $this->assertEquals($this->owner->fresh()->businesses()->first()->description, 'A new description');
    }

    /**
     * @test
     */
    public function it_deactivates_the_business()
    {
        $this->arrangeBusinessWithOwner();

        $this->assertCount(1, $this->owner->fresh()->businesses);

        $this->actingAs($this->owner);

        $this->call('DELETE', route('manager.business.destroy', $this->business));

        $this->assertCount(0, $this->owner->fresh()->businesses);
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
