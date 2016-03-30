<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class SendBusinessReportTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_sends_business_report()
    {
        $exitCode = Artisan::call('business:report');

        $this->assertEquals(0, $exitCode);
    }
}
