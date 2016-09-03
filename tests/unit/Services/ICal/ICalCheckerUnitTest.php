<?php

use App\TG\ICalChecker;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ICalCheckerUnitTest extends TestCase
{
    /**
     * @var ICalEvents
     */
    protected $icalchecker;

    public function setUp()
    {
        parent::setUp();

        $this->icalchecker = new ICalChecker;

        $this->icalchecker->loadString($this->getStub());
    }

    /**
     * @test
     */
    public function it_gets_events_from_string()
    {
        $events = $this->icalchecker->all();

        $this->assertInstanceOf(Collection::class, $events);
    }

    /**
     * @test
     */
    public function it_determines_if_busy_for_timeslot()
    {
        $busy = $this->icalchecker->isBusy(Carbon::parse('2016-07-11 23:10')->timezone('America/Argentina/Buenos_Aires'));

        $this->assertTrue($busy);

        $busy = $this->icalchecker->isBusy(Carbon::parse('2016-07-11 23:30')->timezone('America/Argentina/Buenos_Aires'));

        $this->assertFalse($busy);

        $busy = $this->icalchecker->isBusy(Carbon::parse('2099-12-01 00:30')->timezone('America/Argentina/Buenos_Aires'));

        $this->assertFalse($busy);
    }

    protected function getStub()
    {
        return file_get_contents(__DIR__.'/stubs/ical-stub.ics');
    }
}
