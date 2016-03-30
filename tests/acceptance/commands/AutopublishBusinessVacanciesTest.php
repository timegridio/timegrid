<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class AutopublishBusinessVacanciesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_autopublishes_business_vacancies()
    {
        $exitCode = Artisan::call('business:vacancies');

        $this->assertEquals(0, $exitCode);
    }
}
