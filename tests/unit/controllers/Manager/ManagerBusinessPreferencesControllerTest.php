<?php

use App\Models\Business;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @covers  App\Http\Controllers\Manager\BusinessPreferencesController
 */
class ManagerBusinessPreferencesControllerTest extends TestCase
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
     * @covers   App\Http\Controllers\Manager\BusinessPreferencesController::getPreferences
     * @test
     */
    public function it_shows_the_business_preferences_page()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.preferences', $this->business));

        $this->assertResponseOk();
        $this->see('Here you can customize the business settings to your needs');
    }

    /**
     * @covers   App\Http\Controllers\Manager\BusinessPreferencesController::postPreferences
     * @covers   App\Http\Controllers\Manager\BusinessPreferencesController::setBusinessPreferences
     * @test
     */
    public function it_updates_the_business_preferences()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $assertInDatabase = [
            'preferenceable_id'   => $this->business->id,
            'preferenceable_type' => Business::class,
            'key'                 => 'show_map',
            'value'               => 1,
            ];

        $this->dontSeeInDatabase('preferences', $assertInDatabase);

        $data = [
            'show_map' => 1,
            ];

        $this->call('POST', route('manager.business.preferences', $this->business, [
            'business' => $this->business, ]),
            $data
            );

        $this->seeInDatabase('preferences', $assertInDatabase);
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
