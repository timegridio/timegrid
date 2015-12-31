<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laracasts\TestDummy\Factory;

class AppointmentTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateContact, CreateBusiness, CreateAppointment;

    /**
     * @test
     */
    public function it_creates_an_appointment()
    {
        $appointment = Factory::create('App\Models\Appointment');

        $this->assertInstanceOf(Appointment::class, $appointment);
    }

    /**
     * @covers \App\Models\Appointment::user
     * @test
     */
    public function it_gets_the_contact_user_of_appointment()
    {
        $user = $this->createUser();

        $contact = $this->makeContact($user);
        $contact->save();

        $business = $this->makeBusiness($user);
        $business->save();

        $appointment = $this->makeAppointment($business, $user, $contact);

        $this->assertEquals($user, $appointment->user());
    }

    /**
     * @covers \App\Models\Appointment::user
     * @test
     */
    public function it_gets_no_user_from_contact_of_appointment()
    {
        $issuer = $this->makeUser();
        $contact = $this->makeContact();
        $business = $this->makeBusiness($issuer);
        $appointment = $this->makeAppointment($business, $issuer, $contact);

        $this->assertNull($appointment->user());
    }

    /**
     * @covers \App\Models\Appointment::duplicates
     * @test
     */
    public function it_detects_a_duplicate_appointment()
    {
        $issuer = $this->createUser();

        $contact = $this->createContact();

        $business = $this->makeBusiness($issuer);
        $business->save();

        $appointment = $this->makeAppointment($business, $issuer, $contact);
        $appointment->save();

        $appointmentDuplicate = $this->makeAppointment($business, $issuer, $contact);

        $this->assertTrue($appointmentDuplicate->duplicates());
    }

    /**
     * @covers \App\Models\Appointment::getFinishAtAttribute
     * @test
     */
    public function it_gets_the_finish_datetime_of_appointment()
    {
        $appointment = Factory::create('App\Models\Appointment', [
            'startAt'  => Carbon::parse('2015-12-08 08:00:00 UTC'),
            'duration' => 90,
        ]);

        $startAt = $appointment->startAt;
        $finishAt = $appointment->finishAt;

        $this->assertEquals('2015-12-08 09:30:00', $finishAt);
    }

    /**
     * @covers \App\Models\Appointment::vacancy
     * @test
     */
    public function it_gets_the_associated_vacancy()
    {
        $business = $this->createBusiness();

        $vacancy = Factory::create(Vacancy::class, [
            'business_id' => $business->id,
            ]);

        $appointment = Factory::create(Appointment::class, [
            'business_id' => $business->id,
            'vacancy_id'  => $vacancy->id,
            'startAt'     => Carbon::parse('2015-12-08 08:00:00 UTC'),
            'duration'    => 90,
            ]);

        $this->assertInstanceOf(Vacancy::class, $appointment->vacancy);
    }

    /**
     * @covers \App\Models\Appointment::getDateAttribute
     * @test
     */
    public function it_gets_the_date_attribute_at_000000utc()
    {
        $business = $this->createBusiness();

        $appointment = Factory::create(Appointment::class, [
            'business_id' => $business->id,
            'startAt'     => Carbon::parse('2015-12-08 00:00:00 UTC'),
            'duration'    => 90,
            ]);

        $this->assertEquals($appointment->start_at->timezone($business->timezone)->toDateString(), $appointment->date);
    }

    /**
     * @covers \App\Models\Appointment::getDateAttribute
     * @test
     */
    public function it_gets_the_date_attribute_at_120000utc()
    {
        $business = $this->createBusiness();

        $appointment = Factory::create(Appointment::class, [
            'business_id' => $business->id,
            'startAt'     => Carbon::parse('2015-12-08 12:00:00 UTC'),
            'duration'    => 90,
            ]);

        $this->assertEquals($appointment->start_at->timezone($business->timezone)->toDateString(), $appointment->date);
    }

    /**
     * @covers \App\Models\Appointment::getDateAttribute
     * @test
     */
    public function it_gets_the_date_attribute_at_235959utc()
    {
        $business = $this->createBusiness();

        $appointment = Factory::create(Appointment::class, [
            'business_id' => $business->id,
            'startAt'     => Carbon::parse('2015-12-08 23:59:59 UTC'),
            'duration'    => 90,
            ]);

        $this->assertEquals($appointment->start_at->timezone($business->timezone)->toDateString(), $appointment->date);
    }

    /**
     * @covers \App\Models\Appointment::isReserved
     * @test
     */
    public function it_returns_is_reserved()
    {
        $appointment = Factory::create(Appointment::class, [
            'status' => Appointment::STATUS_RESERVED,
            ]);

        $this->assertTrue($appointment->isReserved());
    }

    /**
     * @covers \App\Models\Appointment::isPending
     * @test
     */
    public function it_returns_is_pending()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->addDays(1),
            'status'   => Appointment::STATUS_RESERVED,
            ]);

        $this->assertTrue($appointment->isPending());
    }

    /**
     * @covers \App\Models\Appointment::isPending
     * @test
     */
    public function it_returns_is_not_pending()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->subDays(1),
            'status'   => Appointment::STATUS_RESERVED,
            ]);

        $this->assertFalse($appointment->isPending());
    }

    /**
     * @covers \App\Models\Appointment::doConfirm
     * @test
     */
    public function it_changes_status_to_confirmed()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->addDays(1),
            'status'   => Appointment::STATUS_RESERVED,
            ]);

        $appointment->doConfirm();

        $this->assertEquals(Appointment::STATUS_CONFIRMED, $appointment->status);
    }

    /**
     * @covers \App\Models\Appointment::doAnnulate
     * @test
     */
    public function it_changes_status_to_annulated()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->addDays(1),
            'status'   => Appointment::STATUS_ANNULATED,
            ]);

        $appointment->doAnnulate();

        $this->assertEquals(Appointment::STATUS_ANNULATED, $appointment->status);
    }

    /**
     * @covers \App\Models\Appointment::doServe
     * @test
     */
    public function it_changes_status_to_served()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->addDays(1),
            'status'   => Appointment::STATUS_SERVED,
            ]);

        $appointment->doAnnulate();

        $this->assertEquals(Appointment::STATUS_SERVED, $appointment->status);
    }

    /**
     * @covers \App\Models\Appointment::doReserve
     * @test
     */
    public function it_sets_status_to_reserved()
    {
        $appointment = factory(Appointment::class)->make([
            'status'   => null,
            'start_at' => Carbon::now()->addDays(5),
            ]);

        $appointment->doReserve();

        $this->assertEquals(Appointment::STATUS_RESERVED, $appointment->status);
    }

    /**
     * @covers \App\Models\Appointment::doServe
     * @test
     */
    public function it_cannot_serve_if_annulated()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->subDays(1),
            'status'   => Appointment::STATUS_ANNULATED,
            ]);

        $appointment->doServe();

        $this->assertEquals(Appointment::STATUS_ANNULATED, $appointment->status);
    }

    /**
     * @covers \App\Models\Appointment::doServe
     * @test
     */
    public function it_cannot_confirm_if_annulated()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->subDays(1),
            'status'   => Appointment::STATUS_ANNULATED,
            ]);

        $appointment->doConfirm();

        $this->assertEquals(Appointment::STATUS_ANNULATED, $appointment->status);
    }

    /**
     * @covers \App\Models\Appointment::doServe
     * @test
     */
    public function it_cannot_annulate_if_served()
    {
        $appointment = Factory::create(Appointment::class, [
            'start_at' => Carbon::now()->subDays(1),
            'status'   => Appointment::STATUS_SERVED,
            ]);

        $appointment->doServe();

        $this->assertEquals(Appointment::STATUS_SERVED, $appointment->status);
    }
}
