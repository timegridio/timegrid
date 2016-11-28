<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Humanresource;

class ManagerHumanresourceControllerTest extends TestCase
{
    use DatabaseTransactions;
    use ArrangeFixture, CreateBusiness, CreateUser, CreateContact, CreateService, CreateVacancy, CreateHumanresource;

    /**
     * @test
     */
    public function it_adds_a_staff_member()
    {
        $this->arrangeFixture();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.humanresource.index', $this->business));

        $this->click('Add');

        $this->type('Lucy Doe', 'name');
        $this->type('1', 'capacity');

        $this->press('Save');

        $this->see('Staff member added');
        $this->see('Lucy Doe');
    }

    /**
     * @test
     */
    public function it_removes_a_staff_member()
    {
        $this->arrangeFixture();

        $humanresource = $this->createHumanResource([
            'business_id' => $this->business->id
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.humanresource.index', $this->business));

        $this->see($humanresource->name);

        $this->call('DELETE', route('manager.business.humanresource.destroy', [
            'business' => $this->business,
            'humanresource' => $humanresource->id
            ]));

        $assertInDatabase = [
            'name'   => $humanresource->name,
            ];

        $this->dontSeeInDatabase('humanresources', $assertInDatabase);
    }

    /**
     * @test
     */
    public function it_updates_a_staff_member()
    {
        $this->arrangeFixture();

        $humanresource = $this->createHumanResource([
            'business_id' => $this->business->id
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.humanresource.edit', [
            'business' => $this->business,
            'humanresource' => $humanresource->id
            ]));

        $this->type('Lucie Doe', 'name');
        $this->type('2', 'capacity');

        $this->press('Update');

        $this->see('Staff member updated');
        $this->see('Lucie Doe');
        $this->see('2');
    }

    /**
     * @test
     */
    public function it_shows_a_staff_member()
    {
        $this->arrangeFixture();

        $humanresource = $this->createHumanResource([
            'business_id' => $this->business->id
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.humanresource.show', [
            'business' => $this->business,
            'humanresource' => $humanresource->id
            ]));

        $this->see($humanresource->name);
    }

    /**
     * @test
     */
    public function it_updates_a_staff_member_with_calendar_link()
    {
        $this->arrangeFixture();

        $humanresource = $this->createHumanResource([
            'business_id' => $this->business->id
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.humanresource.edit', [
            'business' => $this->business,
            'humanresource' => $humanresource->id
            ]));

        $calendar_link = 'http://example.org/ical.ics';
        $this->type($calendar_link, 'calendar_link');

        $this->press('Update');

        $this->seeInDatabase('humanresources', ['id' => $humanresource->id, 'calendar_link' => $calendar_link]);
    }

    /**
     * @test
     */
    public function it_updates_a_staff_member_and_unsets_calendar_link()
    {
        $this->arrangeFixture();

        $humanresource = $this->createHumanResource([
            'business_id' => $this->business->id
            ]);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.humanresource.edit', [
            'business' => $this->business,
            'humanresource' => $humanresource->id
            ]));

        $this->type('', 'calendar_link');

        $this->press('Update');

        $this->seeInDatabase('humanresources', ['id' => $humanresource->id, 'calendar_link' => null]);
    }
}
