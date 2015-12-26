<?php

use App\Models\Business;
use App\Models\Service;
use App\Models\Vacancy;
use App\Services\VacancyParserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VacancyParserTest extends TestCase
{
    use DatabaseTransactions;

    private $vacancyParser;

    public function setUp()
    {
        parent::setUp();

        $this->vacancyParser = new VacancyParserService();

        $this->setFixture();
    }

    protected function setfixture()
    {
        $business = factory(Business::class)->create();

        $service1 = factory(Service::class)->create([
            'business_id' => $business->id,
            'name'        => 'Massage',
            'slug'        => 'massage',
            'duration'    => 30,
        ]);
        $service2 = factory(Service::class)->create([
            'business_id' => $business->id,
            'name'        => 'Relax',
            'slug'        => 'relax',
            'duration'    => 30,
        ]);
    }

    /////////////////////
    // VACANCY PARSING //
    /////////////////////

    /**
     * @test
     */
    public function it_parses_vacancies()
    {
        $vacancyString = <<<EOD
massage:1
 mon,tue
  8-12,14-20

massage:2
 mon,tue,fri
  9-14
EOD;

        $parsedStatements = $this->vacancyParser->parseStatements($vacancyString);

        $this->assertCount(7, $parsedStatements);
    }

    /////////////////////
    // SERVICE PARSING //
    /////////////////////

    /**
     * @test
     */
    public function it_splits_services()
    {
        $services = $this->vacancyParser->splitServices('massage:1, relax:2, stones, massage-other:1');

        $array = [
            'massage:1',
            'relax:2',
            'stones',
            'massage-other:1',
        ];

        $this->assertEquals($services, $array);
    }

    /**
     * @test
     */
    public function it_splits_service_capacity()
    {
        $services = $this->vacancyParser->services('massage:1, relax:2, stones, massage-other:1');

        $array = [
            ['slug' => 'massage', 'capacity' => 1],
            ['slug' => 'relax', 'capacity' => 2],
            ['slug' => 'stones', 'capacity' => 1],
            ['slug' => 'massage-other', 'capacity' => 1],
        ];

        $this->assertEquals($services, $array);
    }

    //////////////////
    // DATE PARSING //
    //////////////////

    /**
     * @test
     */
    public function it_splits_dates()
    {
        $dates = $this->vacancyParser->splitDates('mon,tue,wed,thu,fri,sat,sun');

        $array = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        $this->assertEquals($dates, $array);
    }

    /**
     * @test
     */
    public function it_splits_and_convert_dates()
    {
        $dates = $this->vacancyParser->dates('next mon, next tue, next wed, next thu, next fri, next sat, next sun');

        $array = [
            date('Y-m-d', strtotime('next mon')),
            date('Y-m-d', strtotime('next tue')),
            date('Y-m-d', strtotime('next wed')),
            date('Y-m-d', strtotime('next thu')),
            date('Y-m-d', strtotime('next fri')),
            date('Y-m-d', strtotime('next sat')),
            date('Y-m-d', strtotime('next sun')),
        ];

        $this->assertEquals($dates, $array);
    }

    /**
     * @test
     */
    public function it_splits_and_convert_human_dates()
    {
        $dates = $this->vacancyParser->dates('today, tomorrow, 2015-11-10, 2015-11-10 + 1 day');

        $array = [
            date('Y-m-d', strtotime('today')),
            date('Y-m-d', strtotime('tomorrow')),
            date('Y-m-d', strtotime('2015-11-10')),
            date('Y-m-d', strtotime('2015-11-11')),
        ];

        $this->assertEquals($dates, $array);
    }

    //////////////////
    // TIME PARSING //
    //////////////////

    /**
     * @test
     */
    public function it_splits_the_elements_by_date_timerange_service()
    {
        $hours = $this->vacancyParser->hours('830-1130,14-20,2215-2330,2330-2345');

        $array = [
            ['startAt' =>  '8:30', 'finishAt' => '11:30'],
            ['startAt' => '14:00', 'finishAt' => '20:00'],
            ['startAt' => '22:15', 'finishAt' => '23:30'],
            ['startAt' => '23:30', 'finishAt' => '23:45'],
        ];

        $this->assertEquals($hours, $array);
    }

    /**
     * @test
     */
    public function it_splits_the_elements_by_date_timerange_service_allowing_spaces()
    {
        $hours = $this->vacancyParser->hours('830 - 1130, 14 - 20, 2215 - 2330, 2330 - 2345');

        $array = [
            ['startAt' =>  '8:30', 'finishAt' => '11:30'],
            ['startAt' => '14:00', 'finishAt' => '20:00'],
            ['startAt' => '22:15', 'finishAt' => '23:30'],
            ['startAt' => '23:30', 'finishAt' => '23:45'],
        ];

        $this->assertEquals($hours, $array);
    }

    /**
     * @test
     */
    public function it_converts_empty_military_time_to_empty_string()
    {
        $time = $this->vacancyParser->milTimeToStandard('');

        $returns = '';

        $this->assertEquals($time, $returns);
    }

    /**
     * @test
     */
    public function it_converts_military_time_to_standard()
    {
        $time = $this->vacancyParser->milTimeToStandard('830');

        $returns = '8:30';

        $this->assertEquals($time, $returns);
    }

    /**
     * @test
     */
    public function it_keeps_standard_time_into_standard()
    {
        $time = $this->vacancyParser->milTimeToStandard('8:30');

        $returns = '8:30';

        $this->assertEquals($time, $returns);
    }
}
