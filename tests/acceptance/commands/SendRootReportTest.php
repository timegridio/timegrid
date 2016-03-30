<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class SendRootReportTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_sends_root_report()
    {
        $exitCode = Artisan::call('root:report');

        $this->assertEquals(0, $exitCode);
    }
}
