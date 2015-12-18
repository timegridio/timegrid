<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use App\Services\ConciergeService;
use App\Services\VacancyService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConciergeServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * [$user description].
     *
     * @var [type]
     */
    protected $user;

    /**
     * [$business description].
     *
     * @var [type]
     */
    protected $business;

    /**
     * [$contact description].
     *
     * @var [type]
     */
    protected $contact;

    /**
     * [$service description].
     *
     * @var [type]
     */
    protected $service;

    /**
     * [$vacancy description].
     *
     * @var [type]
     */
    protected $vacancy;

    /**
     * [$concierge description].
     *
     * @var [type]
     */
    protected $concierge;

    /////////////
    // HELPERS //
    /////////////

    /**
     * arrange a fixed scenario for testing.
     *
     * @return void
     */
    protected function arrangeScenario()
    {
        // Common Arrange
        $this->user = factory(User::class)->create();

        $this->business = factory(Business::class)->create();

        $this->service = factory(Service::class)->make();

        $this->business->services()->save($this->service);

        $this->concierge = new ConciergeService(new VacancyService);

        $this->concierge->setBusiness($this->business);
    }

    /**
     * make date time object with timezone.
     *
     * @param string $date        Date
     * @param string $time        Time
     * @param string $timezone    TimeZone
     * @param string $modificator Ex: +1 day
     *
     * @return Carbon DateTime
     */
    protected function makeDateTime($date, $time, $timezone, $modificator = '')
    {
        $strDateTime = date('Y-m-d H:i:s', strtotime("{$date} {$time} {$modificator}"));

        return Carbon::parse($strDateTime, $timezone);
    }

    ///////////
    // TESTS //
    ///////////

    /**
     * Test get vacancies from Concierge Service Layer.
     *
     * @covers     \App\Services\ConciergeService::getVacancies
     *
     * @return bool Vacancy found
     * @test
     */
    public function testConciergeGetVacancies()
    {
        // Arrange
        $this->arrangeScenario();

        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->business()->associate($this->business);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        // Act
        $vacancies = $this->concierge->getVacancies($this->user);

        // Assert
        return $this->assertContainsOnly($this->vacancy, $vacancies[$this->vacancy->date]);
    }

    /**
     * Test get empty vacancies from Concierge Service Layer.
     *
     * @covers            \App\Services\ConciergeService::getVacancies
     * @test
     */
    public function testConciergeGetEmptyVacancies()
    {
        // Arrange
        $this->arrangeScenario();

        // Act
        $vacancies = $this->concierge->getVacancies($this->user);

        // Assert
        foreach ($vacancies as $vacancy) {
            $this->assertContainsOnly([], $vacancy);
        }
    }

    /**
     * Test Make Successful Reservation.
     *
     * @covers            \App\Services\ConciergeService::makeReservation
     * @test
     */
    public function testMakeSuccessfulReservation()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->business()->associate($this->business);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        // Act
        $date = $this->makeDateTime(
            $this->vacancy->date,
            $this->vacancy->business->pref('start_at'),
            $this->business->timezone
            );

        $appointment = $this->concierge->makeReservation(
            $this->user,
            $this->business,
            $this->contact,
            $this->service,
            $date
            );

        // Assert
        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertTrue($appointment->exists);
    }

    /**
     * Test Make Successful Reservation.
     *
     * @covers            \App\Services\ConciergeService::makeReservation
     * @test
     */
    public function testBlockOverbooking()
    {
        // Arrange
        $this->arrangeScenario();

        $this->vacancy = factory(Vacancy::class)->make(['capacity' => 1]);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        // Act
        $date = $this->makeDateTime(
            $this->vacancy->date,
            $this->vacancy->business->pref('start_at'),
            $this->business->timezone
            );

        $appointment = $this->concierge->makeReservation(
            $this->user,
            $this->business,
            $this->contact,
            $this->service,
            $date
            );

        $date = $this->makeDateTime(
            $this->vacancy->date,
            $this->vacancy->business->pref('start_at'),
            $this->business->timezone,
            '+30 minutes'
            );

        $appointmentOverbook = $this->concierge->makeReservation(
            $this->user,
            $this->business,
            $this->contact,
            $this->service,
            $date
            );

        // Assert
        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertTrue($appointment->exists);
        $this->assertFalse($appointmentOverbook);
    }

    /**
     * Test Attempt Bad Reservation.
     *
     * @covers            \App\Services\ConciergeService::makeReservation
     * @test
     */
    public function testAttemptBadReservation()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->business()->associate($this->business);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        // Act
        $date = $this->makeDateTime(
            $this->vacancy->date,
            $this->vacancy->business->pref('start_at'),
            $this->business->timezone,
            '+1 day'
            );

        $appointment = $this->concierge->makeReservation(
            $this->user,
            $this->business,
            $this->contact,
            $this->service,
            $date
            );

        // Assert
        $this->assertFalse($appointment);
    }

    /**
     * @covers            \App\Services\ConciergeService::getUnservedAppointments
     * @test
     */
    public function it_gets_the_unserved_appointments()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->business()->associate($this->business);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->contact()->associate($this->contact);
        $appointment->issuer()->associate($this->user);
        $appointment->business()->associate($this->business);
        $appointment->save();

        $this->concierge->setBusiness($this->business);
        $appointments = $this->concierge->getUnservedAppointments();

        // Assert
        $this->assertInstanceOf(Collection::class, $appointments);
        $this->assertEquals(1, $appointments->count());
    }

    /**
     * @covers            \App\Services\ConciergeService::getUnservedAppointments
     * @test
     */
    public function it_gets_the_unserved_appointments_and_omits_those_served()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->business()->associate($this->business);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_SERVED]);
        $appointment->contact()->associate($this->contact);
        $appointment->issuer()->associate($this->user);
        $appointment->business()->associate($this->business);
        $appointment->save();

        $this->concierge->setBusiness($this->business);
        $appointments = $this->concierge->getUnservedAppointments();

        // Assert
        $this->assertInstanceOf(Collection::class, $appointments);
        $this->assertEquals(0, $appointments->count());
    }
}
