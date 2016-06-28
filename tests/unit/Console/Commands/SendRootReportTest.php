<?php

use App\Console\Commands\SendRootReport;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;

class SendRootReportTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    protected $command;

    protected $commandTester;

    public function setUp()
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(SendRootReport::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('root:report');

        $this->commandTester = new CommandTester($this->command);

        $this->arrangeFixture();
    }

    /** @test */
    public function it_reports_to_root()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $this->assertRegExp('/Root report was sent/', $this->commandTester->getDisplay());
    }

    protected function arrangeFixture()
    {
        $this->createUsers(10);
    }
}
