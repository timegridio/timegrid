<?php

use App\Console\Commands\AutopublishBusinessVacancies;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;

class AutopublishBusinessVacanciesTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness;

    protected $command;

    protected $commandTester;

    /**
     * @var \Timegridio\Concierge\Models\Business
     */
    protected $business;

    public function setUp()
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(AutopublishBusinessVacancies::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('business:vacancies');

        $this->commandTester = new CommandTester($this->command);

        $this->arrangeFixture();
    }

    /** @test */
    public function it_processes_all_businesses()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $this->assertRegExp('/Scanning all businesses/', $this->commandTester->getDisplay());
    }

    /** @test */
    public function it_processes_a_single_business()
    {
        $this->commandTester->execute([
            'command'  => $this->command->getName(),
            'business' => $this->business->id,
        ]);

        $this->assertRegExp("/Publishing vacancies for businessId:{$this->business->id}/", $this->commandTester->getDisplay());
    }

    /** @test */
    public function it_skips_reporting_if_preference_is_not_set()
    {
        $this->business->pref('vacancy_autopublish', false);

        $this->commandTester->execute([
            'command'  => $this->command->getName(),
            'business' => $this->business->id,
        ]);

        $this->assertRegExp('/Skipped autopublishing vacancies/', $this->commandTester->getDisplay());
    }

    protected function arrangeFixture()
    {
        $this->business = $this->createBusiness();

        $this->business->pref('vacancy_autopublish', true);
    }
}
