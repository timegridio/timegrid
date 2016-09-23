<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use MailThief\Facades\MailThief;
use Timegridio\Concierge\Models\Appointment;

class BusinessReportEmailTest extends TestCase
{
    use CreateUser, CreateBusiness, CreateAppointment;
    use DatabaseTransactions;
    /**
     * @test
     */
    public function it_sends_schedule_report_to_business_on_the_desired_timezone()
    {
        MailThief::hijack();

        $this->arrangeScenario();

        $exitCode = Artisan::call('business:report', ['business' => $this->business->id]);
        $resultAsText = Artisan::output();
        $this->assertEquals(0, $exitCode);
        $this->assertContains("Sending to businessId:{$this->business->id}\n", $resultAsText);

        $emailBody = MailThief::lastMessage()->getBody('text');

        $testAppointment = $this->business->bookings()->first();

        $time = $testAppointment->start_at->timezone($this->business->timezone)->format('h:i a');
        $code = $testAppointment->code;

        $this->assertTrue(MailThief::hasMessageFor($this->owner->email));

        $this->assertContains('Schedule', MailThief::lastMessage()->subject);
        $this->assertContains(date('Y-m-d'), MailThief::lastMessage()->subject);
        $this->assertContains($time, $emailBody);
        $this->assertContains($code, $emailBody);
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function arrangeScenario()
    {
        $this->owner = $this->createUser();

        $this->business = $this->createBusiness();

        $this->business->pref('report_daily_schedule', true);

        $this->business->owners()->save($this->owner);

        $this->createAppointments(1, [
            'business_id' => $this->business->id,
            'issuer_id'   => $this->owner->id,
            'status'      => Appointment::STATUS_CONFIRMED,
            ]);
    }
}
