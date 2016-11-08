<?php

use App\TG\DetectTimezone;
use Torann\GeoIP\GeoIP;

class DetectTimezoneUnitTest extends TestCase
{
    /**
     * @test
     */
    public function it_detects_the_user_timezone()
    {
        $timezone = 'America/New_York';
        $detectTimezone = $this->makeDetectTimezone($timezone);
        $detectedTimezone = $detectTimezone->get();
        $this->assertInternalType('string', $detectedTimezone);
        $this->assertEquals($timezone, $detectedTimezone);
    }

    /**
     * @test
     */
    public function it_converts_to_string()
    {
        $timezone = 'America/New_York';
        $detectTimezone = $this->makeDetectTimezone($timezone);
        $detectedTimezone = $detectTimezone->get();
        $this->assertInternalType('string', "$detectedTimezone");
        $this->assertEquals($timezone, "$detectedTimezone");
    }

    protected function makeDetectTimezone($timezone = 'America/New_York')
    {
        $geoip = $this->makeGeoIP();

        return new DetectTimezone($geoip);
    }

    protected function makeGeoIP(array $config = [], $cacheMock = null)
    {
        $cacheMock = $cacheMock ?: Mockery::mock('Illuminate\Cache\CacheManager');
        $config = array_merge($this->getConfig(), $config);
        $cacheMock->shouldReceive('tags')->with(['torann-geoip-location'])->andReturnSelf();

        return new \Torann\GeoIP\GeoIP($config, $cacheMock);
    }

    protected function getConfig()
    {
        $config = include __DIR__.'/../../../config/geoip.php';
        $this->databaseCheck($config['services']['maxmind_database']['database_path']);

        return $config;
    }

    /**
     * Check for test database and make a copy of it
     * if it does not exist.
     *
     * @param string $database
     */
    protected function databaseCheck($database)
    {
        if (file_exists($database) === false) {
            @mkdir(dirname($database), 0755, true);
            copy(__DIR__.'/../../helpers/stubs/geoip.mmdb', $database);
        }
    }
}
