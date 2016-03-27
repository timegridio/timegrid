<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerBusinessVacancyControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateBusiness, CreateService, CreateVacancy;

    /**
     * @var Timegridio\Concierge\Models\Business
     */
    protected $business;

    /**
     * @var App\Models\User
     */
    protected $owner;

    /**
     * Service One.
     *
     * @var Timegridio\Concierge\Models\Service
     */
    protected $serviceOne;

    /**
     * Service Two.
     *
     * @var Timegridio\Concierge\Models\Service
     */
    protected $serviceTwo;

    /**
     * Service Three.
     *
     * @var Timegridio\Concierge\Models\Service
     */
    protected $serviceThree;

    /**
     * Vacancy.
     *
     * @var Timegridio\Concierge\Models\Vacancy
     */
    protected $vacancy;

    /**
     * @test
     */
    public function it_displays_the_vacancy_management_simple_form()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $this->seePageIs($this->business->slug.'/manage/vacancy/create');
        $this->see('Enter the appointments capacity for each service on each day');
        $this->see($this->serviceOne->name);
        $this->see($this->serviceTwo->name);
        $this->see($this->serviceThree->name);
    }

    /**
     * @test
     */
    public function it_displays_the_vacancy_management_simple_form_with_no_services_warning()
    {
        $this->arrangeBusinessWithOwner();

        $this->business->services()->delete();

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $this->seePageIs($this->business->slug.'/manage/vacancy/create');
        $this->see('Enter the appointments capacity for each service on each day');
        $this->see('No services registered. Please register services for your business');

        $this->dontSee($this->serviceOne->name);
        $this->dontSee($this->serviceTwo->name);
        $this->dontSee($this->serviceThree->name);
    }

    /**
     * @test
     */
    public function it_displays_the_vacancy_management_advanced_form()
    {
        $this->arrangeBusinessWithOwner();
        $serviceFour = $this->createService();
        $serviceFive = $this->createService();
        $serviceSix = $this->createService();

        $this->business->services()->save($serviceFour);
        $this->business->services()->save($serviceFive);
        $this->business->services()->save($serviceSix);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $this->seePageIs($this->business->slug.'/manage/vacancy/create');
        $this->see('Enter the appointments capacity for each service on each day');
        $this->see($this->serviceOne->name);
        $this->see($this->serviceTwo->name);
        $this->see($this->serviceThree->name);
        $this->see($serviceFour->name);
        $this->see($serviceFive->name);
        $this->see($serviceSix->name);
    }

    /**
     * @test
     */
    public function it_updates_the_vacancy_in_simple_mode()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->vacancy->business->owner());

        $this->visit(route('manager.business.vacancy.create', $this->vacancy->business));

        $newCapacity = $this->vacancy->capacity + 5;

        $this->type($newCapacity, "vacancy[{$this->vacancy->date}][{$this->vacancy->service->id}]");

        $this->press('Update');

        $this->assertEquals($this->vacancy->fresh()->capacity, $newCapacity);
    }

    /**
     * @FAILING test
     */
    public function it_skips_blank_updates_for_vacancy_in_simple_mode()
    {
        $this->arrangeBusinessWithOwner();

        $this->actingAs($this->vacancy->business->owner());

        $this->visit(route('manager.business.vacancy.create', $this->vacancy->business));

        $this->type('', "vacancy[{$this->vacancy->date}][{$this->vacancy->service->id}]");

        $this->press('Update');

        $this->see('You must indicate your availability at least for one date');
    }

    /**
     * @test
     */
    public function it_updates_the_vacancy_in_advanced_mode()
    {
        $this->arrangeBusinessWithOwner();
        $serviceFour = $this->createService();
        $serviceFive = $this->createService();
        $serviceSix = $this->createService();

        $this->business->services()->save($serviceFour);
        $this->business->services()->save($serviceFive);
        $this->business->services()->save($serviceSix);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $vacanciesCountBeforeUpdate = $this->business->vacancies->count();

        $newCapacity = 2;

        $sheet =
<<<EOD
{$serviceFour->slug}:$newCapacity
 mon, tue, thu
  9 - 14, 15:30 - 18:30
EOD;
        $this->type($sheet, 'vacancies');

        $this->press('Update');

        $this->assertCount($vacanciesCountBeforeUpdate + 6, $this->business->fresh()->vacancies);
    }

    /**
     * @test
     */
    public function it_remembers_the_published_vacancies()
    {
        $this->arrangeBusinessWithOwner();
        $serviceFour = $this->createService();
        $serviceFive = $this->createService();
        $serviceSix = $this->createService();

        $this->business->services()->save($serviceFour);
        $this->business->services()->save($serviceFive);
        $this->business->services()->save($serviceSix);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $vacanciesCountBeforeUpdate = $this->business->vacancies->count();

        $newCapacity = 2;

        $sheet =
<<<EOD
{$serviceFour->slug}:$newCapacity
 mon, tue, thu
  9 - 14, 15:30 - 18:30
EOD;
        $this->type($sheet, 'vacancies');

        $this->check('remember');

        $this->press('Update');

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $this->see($sheet);
    }

    /**
     * @test
     */
    public function it_forgets_the_published_vacancies()
    {
        $this->arrangeBusinessWithOwner();
        $serviceFour = $this->createService();
        $serviceFive = $this->createService();
        $serviceSix = $this->createService();

        $this->business->services()->save($serviceFour);
        $this->business->services()->save($serviceFive);
        $this->business->services()->save($serviceSix);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $vacanciesCountBeforeUpdate = $this->business->vacancies->count();

        $newCapacity = 2;

        $sheet =
<<<EOD
{$serviceFour->slug}:$newCapacity
 mon, tue, thu
  9 - 14, 15:30 - 18:30
EOD;
        $this->type($sheet, 'vacancies');

        // $this->check('remember');

        $this->press('Update');

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $this->dontSee($sheet);
    }

    /**
     * @FAILING test
     */
    public function it_skips_blank_updates_the_vacancy_in_advanced_mode()
    {
        $this->arrangeBusinessWithOwner();
        $serviceFour = $this->createService();
        $serviceFive = $this->createService();
        $serviceSix = $this->createService();

        $this->business->services()->save($serviceFour);
        $this->business->services()->save($serviceFive);
        $this->business->services()->save($serviceSix);

        $this->business->pref('vacancy_edit_advanced_mode', true);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $this->type('', 'vacancies');

        $this->press('Update');

        $this->see('You must indicate your availability at least for one date');
    }

    /**
     * @test
     */
    public function it_updates_the_vacancy_in_advanced_mode_and_omits_invalid_services()
    {
        $this->arrangeBusinessWithOwner();
        $serviceFour = $this->createService();
        $serviceFive = $this->createService();
        $serviceSix = $this->createService();

        $this->business->services()->save($serviceFour);
        $this->business->services()->save($serviceFive);
        $this->business->services()->save($serviceSix);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.create', $this->business));

        $vacanciesCountBeforeUpdate = $this->business->vacancies->count();

        $newCapacity = 2;

        $sheet =
<<<EOD
{$serviceFour->slug}:$newCapacity, anInvalidService:1
 mon, tue, thu
  9 - 14, 15:30 - 18:30
EOD;
        $this->type($sheet, 'vacancies');

        $this->press('Update');

        $this->assertCount($vacanciesCountBeforeUpdate + 6, $this->business->fresh()->vacancies);
    }

    /**
     * @test
     */
    public function it_displays_the_vacancy_management_table_on_timeslot()
    {
        $this->arrangeBusinessWithOwner();

        $this->business->update(['strategy' => 'timeslot']);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.show', $this->business));

        $this->seePageIs($this->business->slug.'/manage/vacancy/show');
        $this->see($this->vacancy->service->slug);
    }

    /**
     * @test
     */
    public function it_displays_no_services_warning_upon_timetable_show()
    {
        $this->business = $this->createBusiness(['strategy' => 'timeslot']);

        $this->owner = $this->createUser();

        $this->business->owners()->save($this->owner);

        $this->actingAs($this->owner);

        $this->visit(route('manager.business.vacancy.show', $this->business));

        $this->see('No services registered');
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function arrangeBusinessWithOwner()
    {
        $this->owner = $this->createUser();

        $this->business = $this->createBusiness();

        $this->business->owners()->save($this->owner);

        $this->serviceOne = $this->createService();
        $this->serviceTwo = $this->createService();
        $this->serviceThree = $this->createService();

        $this->business->services()->save($this->serviceOne);
        $this->business->services()->save($this->serviceTwo);
        $this->business->services()->save($this->serviceThree);

        $this->vacancy = $this->createVacancy([
            'business_id' => $this->business->id,
            'service_id'  => $this->serviceOne->id,
            ]);
    }
}
