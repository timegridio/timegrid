<?php

use App\Console\Commands\SyncICal;
use App\Services\Availability\ICalSyncService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;

class SyncICalTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateHumanresource;

    protected $command;

    protected $commandTester;

    protected $business;

    public function setUp()
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $icalsync = Mockery::mock(ICalSyncService::class)->makePartial();

        $icalsync->shouldReceive('sync')->once()->andReturn();

        $testedCommand = $this->app->make(SyncICal::class, [$icalsync]);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('ical:sync');

        $this->commandTester = new CommandTester($this->command);

        $this->arrangeFixture();
    }

    /** @test */
    public function it_syncs_ical_for_all_businesses()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $this->assertRegExp('/Syncing ICal for all businesses/', $this->commandTester->getDisplay());
    }

    /** @test */
    public function it_syncs_ical_for_a_single_business()
    {
        $this->commandTester->execute([
            'command'  => $this->command->getName(),
            'business' => $this->business->id,
        ]);

        $this->assertRegExp("/Syncing ICal for {$this->business->id}/", $this->commandTester->getDisplay());
    }

    protected function arrangeFixture()
    {
        $this->business = $this->createBusiness();
        $this->createHumanResource([
            'business_id'   => $this->business->id,
            'calendar_link' => 'http://localhost/ical/example.ics',
            ]);
    }
}
