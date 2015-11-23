<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServiceUnitTest extends TestCase
{
    use DatabaseTransactions;

    public function testServiceCreationWithSuccess()
    {
        $service = factory(App\Service::class)->make();
    }
}
