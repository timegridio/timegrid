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
        $timezone = 'Europe/London';

        $detectTimezone = $this->getTestObject($timezone);

        $detectedTimezone = $detectTimezone->get();

        $this->assertInternalType('string', $detectedTimezone);
        $this->assertEquals($timezone, $detectedTimezone);
    }

    /**
     * @test
     */
    public function it_converts_to_string()
    {
        $timezone = 'Europe/London';

        $detectTimezone = $this->getTestObject($timezone);

        $detectedTimezone = $detectTimezone->get();

        $this->assertInternalType('string', "$detectedTimezone");
        $this->assertEquals($timezone, "$detectedTimezone");
    }

    protected function getTestObject($timezone = 'Europe/London')
    {
        $geoip = Mockery::mock(GeoIP::class)->makePartial();

        $geoip->shouldReceive('getLocation')->once()->andReturn(compact('timezone'));

        return new DetectTimezone($geoip);
    }
}
