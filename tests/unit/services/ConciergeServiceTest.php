<?php

use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Vacancy;
use App\Services\ConciergeService;
use App\Services\VacancyService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConciergeServiceTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateContact, CreateBusiness, CreateService, CreateAppointment;

    protected $user;

    protected $business;

    protected $contact;

    protected $service;

    protected $vacancy;

    protected $concierge;

    /**
     * @covers \App\Services\ConciergeService::getVacancies
     * @test
     */
    public function it_returns_vacancies()
    {
        // Arrange
        $this->arrangeScenario();

        $this->vacancy = factory(Vacancy::class)->make();
        $this->vacancy->service()->associate($this->service);

        // Act
        $vacancies = $this->concierge->setBusiness($this->business)->getVacancies($this->user);

        // Assert
        $this->assertContainsOnly($this->vacancy, $vacancies[$this->vacancy->date]);
    }

    /**
     * @covers \App\Services\ConciergeService::getVacancies
     * @test
     */
    public function it_returns_empty_vacancies()
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
     * @covers \App\Services\ConciergeService::makeReservation
     * @test
     */
    public function it_accepts_a_valid_booking()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();

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
     * @covers \App\Services\ConciergeService::makeReservation
     * @test
     */
    public function it_rejects_overbooking()
    {
        // Arrange
        $this->arrangeScenario();

        $this->vacancy = factory(Vacancy::class)->make(['capacity' => 1]);
        $this->vacancy->service()->associate($this->service);
        $this->business->vacancies()->save($this->vacancy);

        $this->contact = $this->createContact();

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
     * @covers \App\Services\ConciergeService::makeReservation
     * @test
     */
    public function it_rejects_invalid_booking()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();

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
     * @covers \App\Services\ConciergeService::getUnservedAppointments
     * @test
     */
    public function it_gets_the_unserved_appointments()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_RESERVED]
            );
        $appointment->save();

        $appointments = $this->concierge->setBusiness($this->business)->getUnservedAppointments();

        // Assert
        $this->assertInstanceOf(Collection::class, $appointments);
        $this->assertEquals(1, $appointments->count());
    }

    /**
     * @covers \App\Services\ConciergeService::getUnservedAppointments
     * @test
     */
    public function it_gets_the_unserved_appointments_and_omits_those_served()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_SERVED]
            );

        $appointments = $this->concierge
                             ->setBusiness($this->business)
                             ->getUnservedAppointments();

        // Assert
        $this->assertInstanceOf(Collection::class, $appointments);
        $this->assertEquals(0, $appointments->count());
    }

    /**
     * @covers \App\Services\ConciergeService::getActiveAppointments
     * @test
     */
    public function it_gets_the_active_appointments()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_RESERVED]
            );
        $appointment->save();

        $appointments = $this->concierge->setBusiness($this->business)->getActiveAppointments();

        // Assert
        $this->assertInstanceOf(Collection::class, $appointments);
        $this->assertEquals(1, $appointments->count());
    }

    /**
     * @covers \App\Services\ConciergeService::requestAction
     * @test
     */
    public function it_annulates_an_appointment()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_RESERVED]
            );

        $appointment = $this->concierge
                            ->setBusiness($this->business)
                            ->requestAction($this->user, $appointment, 'annulate');

        // Assert
        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals(Appointment::STATUS_ANNULATED, $appointment->status);
    }

    /**
     * @covers \App\Services\ConciergeService::requestAction
     * @test
     */
    public function it_confirms_an_appointment()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();
        $this->business->contacts()->save($this->contact);

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_RESERVED]
            );
        $appointment->save();

        $this->expectsEvents(App\Events\AppointmentWasConfirmed::class);

        $appointment = $this->concierge
                            ->setBusiness($this->business)
                            ->requestAction($this->user, $appointment, 'confirm');

        // Assert
        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals(Appointment::STATUS_CONFIRMED, $appointment->status);
    }

    /**
     * @covers \App\Services\ConciergeService::requestAction
     * @test
     */
    public function it_serves_a_due_appointment()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();
        $this->business->contacts()->save($this->contact);

        $appointment = $this->makeAppointment($this->business, $this->user, $this->contact, [
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(1),
            ]);
        $appointment->save();

        $appointment = $this->concierge
                            ->setBusiness($this->business)
                            ->requestAction($this->user, $appointment, 'serve');

        // Assert
        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals(Appointment::STATUS_SERVED, $appointment->status);
    }

    /**
     * @covers \App\Services\ConciergeService::requestAction
     * @expectedException \Exception
     * @test
     */
    public function it_throws_exception_upon_invalid_request()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = $this->createContact();
        $this->business->contacts()->save($this->contact);

        $appointment = $this->makeAppointment($this->business, $this->user, $this->contact, [
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(1),
            ]);
        $appointment->save();

        $appointment = $this->concierge
                            ->setBusiness($this->business)
                            ->requestAction($this->user, $appointment, 'invalidRequest');

        // Assert
        $this->assertEquals(Appointment::STATUS_RESERVED, $appointment->status);
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * Arrange a fixture for testing.
     *
     * @return void
     */
    protected function arrangeScenario()
    {
        $this->user = $this->createUser();

        $this->business = $this->createBusiness();

        $this->service = $this->createService([
            'business_id' => $this->business->id,
            ]);

        $this->concierge = new ConciergeService(new VacancyService());

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
}
