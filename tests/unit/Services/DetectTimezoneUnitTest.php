<?php

use App\Services\DetectTimezone;
use Torann\GeoIP\GeoIP;

class DetectTimezoneUnitTest extends TestCase
{
    /**
     * @test
     */
    public function it_detects_the_user_timezone()
    {
        $testTimezone = 'Europe/London';

        $geoip = Mockery::mock(GeoIP::class)->makePartial();

        $geoip->shouldReceive('getLocation')->once()->andReturn(['timezone' => $testTimezone]);

        $detectTimezone = new DetectTimezone($geoip);

        $timezone = $detectTimezone->get();

        $this->assertInternalType('string', $timezone);
        $this->assertEquals($testTimezone, $timezone);
    }
}
