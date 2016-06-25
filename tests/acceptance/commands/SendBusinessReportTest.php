<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class SendBusinessReportTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_sends_business_report()
    {
        $exitCode = Artisan::call('business:report');

        $resultAsText = Artisan::output();

        $this->assertEquals(0, $exitCode);
        $this->assertEquals($resultAsText, "Scanning all businesses...\n");
    }
}
