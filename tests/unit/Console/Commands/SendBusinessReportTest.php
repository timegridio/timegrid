<?php

use App\Console\Commands\SendBusinessReport;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;
use Timegridio\Concierge\Models\Appointment;

class SendBusinessReportTest extends TestCase
{
    use DatabaseTransactions;
    use CreateBusiness, CreateUser, CreateContact, CreateAppointment;

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

        $testedCommand = $this->app->make(SendBusinessReport::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('business:report');

        $this->commandTester = new CommandTester($this->command);

        $this->arrangeFixture();
    }

    /** @test */
    public function it_reports_to_all_businesses()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $this->assertRegExp('/Scanning all businesses../', $this->commandTester->getDisplay());
    }

    /** @test */
    public function it_reports_to_a_single_business()
    {
        $this->commandTester->execute([
            'command'  => $this->command->getName(),
            'business' => $this->business->id,
        ]);

        $this->assertRegExp("/Sending to businessId:{$this->business->id}/", $this->commandTester->getDisplay());
    }

    protected function arrangeFixture()
    {
        $issuer = $this->createUser();

        $this->business = $this->createBusiness();

        $contact = $this->createContact();

        $this->makeAppointment($this->business, $issuer, $contact, [
            'status' => Appointment::STATUS_CONFIRMED,
            ]);
    }
}
