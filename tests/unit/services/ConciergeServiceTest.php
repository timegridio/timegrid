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

    protected $user;

    protected $business;

    protected $contact;

    protected $service;

    protected $vacancy;

    protected $concierge;

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
        $this->user = factory(User::class)->create();

        $this->business = factory(Business::class)->create();

        $this->service = factory(Service::class)->create([
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

    ///////////
    // TESTS //
    ///////////

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

        $this->contact = factory(Contact::class)->create();

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

        $this->contact = factory(Contact::class)->create();

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

        $this->contact = factory(Contact::class)->create();

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

        $this->contact = factory(Contact::class)->create();

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->contact()->associate($this->contact);
        $appointment->business()->associate($this->business);
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

        $this->contact = factory(Contact::class)->create();

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_SERVED]);

        $appointments = $this->concierge
                             ->setBusiness($this->business)
                             ->getUnservedAppointments();

        // Assert
        $this->assertInstanceOf(Collection::class, $appointments);
        $this->assertEquals(0, $appointments->count());
    }

    /**
     * @covers \App\Services\ConciergeService::requestAction
     * @test
     */
    public function it_annulates_an_appointment()
    {
        // Arrange
        $this->arrangeScenario();

        $this->contact = factory(Contact::class)->create();

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->contact()->associate($this->contact);
        $appointment->business()->associate($this->business);

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

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $appointment = factory(Appointment::class)->make(['status' => Appointment::STATUS_RESERVED]);
        $appointment->contact()->associate($this->contact);
        $appointment->issuer()->associate($this->user);
        $appointment->business()->associate($this->business);
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

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(1),
            ]);
        $appointment->contact()->associate($this->contact);
        $appointment->issuer()->associate($this->user);
        $appointment->business()->associate($this->business);
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

        $this->contact = factory(Contact::class)->create();
        $this->business->contacts()->save($this->contact);

        $appointment = factory(Appointment::class)->make([
            'status'   => Appointment::STATUS_RESERVED,
            'start_at' => Carbon::now()->subDays(1),
            ]);
        $appointment->contact()->associate($this->contact);
        $appointment->issuer()->associate($this->user);
        $appointment->business()->associate($this->business);
        $appointment->save();

        $appointment = $this->concierge
                            ->setBusiness($this->business)
                            ->requestAction($this->user, $appointment, 'invalidRequest');    

        // Assert
        $this->assertEquals(Appointment::STATUS_RESERVED, $appointment->status);
    }
}
