<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManagerBusinessVacancyControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateBusiness, CreateService, CreateVacancy;

    /**
     * @var App\Models\Business
     */
    protected $business;

    /**
     * @var App\Models\User
     */
    protected $owner;

    /**
     * Service One.
     *
     * @var App\Models\Service
     */
    protected $serviceOne;

    /**
     * Service Two.
     *
     * @var App\Models\Service
     */
    protected $serviceTwo;

    /**
     * Service Three.
     *
     * @var App\Models\Service
     */
    protected $serviceThree;

    /**
     * Vacancy.
     *
     * @var App\Models\Vacancy
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

        $this->seePageIs('biz/'.$this->business->slug.'/manage/vacancy/create');
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

        $this->seePageIs('biz/'.$this->business->slug.'/manage/vacancy/create');
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

        $this->seePageIs('biz/'.$this->business->slug.'/manage/vacancy/create');
        $this->see('Enter the appointments capacity for each service on each day');
        $this->dontSee($this->serviceOne->name);
        $this->dontSee($this->serviceTwo->name);
        $this->dontSee($this->serviceThree->name);
        $this->dontSee($serviceFour->name);
        $this->dontSee($serviceFive->name);
        $this->dontSee($serviceSix->name);
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

        $this->seePageIs('biz/'.$this->business->slug.'/manage/vacancy/show');
        $this->see($this->vacancy->service->slug);
    }

    // TODO: Implement the vacancy table for dateslot

//    public function it_displays_the_vacancy_management_table_on_dateslot()
//    {
//        $this->arrangeBusinessWithOwner();
//
//        $this->business->update(['strategy' => 'dateslot']);
//
//        $this->actingAs($this->owner);
//
//        $this->visit(route('manager.business.vacancy.show', $this->business));
//
//        $this->seePageIs($this->business->slug.'/manage/vacancy/show');
//        $this->see($this->vacancy->service->slug);
//    }

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
