<?php

use Timegridio\Concierge\Booking\Strategies\BookingStrategy;
use Timegridio\Concierge\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingStrategyUnitTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateContact, CreateBusiness, CreateService;

    /**
     * @test
     */
    public function it_generates_a_dateslot_appointment()
    {
        $owner = $this->createUser();

        $contact = $this->makeContact($owner);
        $contact->save();

        $business = $this->makeBusiness($owner, ['strategy' => 'dateslot']);
        $business->save();

        $service = $this->makeService();

        $business->services()->save($service);

        $bookingStrategy = new BookingStrategy($business->strategy);

        $dateTime = Carbon::now()->addDays(5);

        $appointment = $bookingStrategy->generateAppointment(
            $owner,
            $business,
            $contact,
            $service,
            $dateTime,
            'test comments'
        );

        $this->assertInstanceOf(Appointment::class, $appointment);

        $this->assertEquals($appointment->issuer->id, $owner->id);
        $this->assertEquals($appointment->contact->name, $contact->name);
        $this->assertEquals($appointment->service->name, $service->name);
        $this->assertEquals($appointment->date, $dateTime->toDateString());
        $this->assertEquals($appointment->comments, 'test comments');

        $this->assertEquals(32, strlen($appointment->hash));
    }

    /**
     * @test
     */
    public function it_generates_a_timeslot_appointment()
    {
        $owner = $this->createUser();

        $contact = $this->makeContact($owner);
        $contact->save();

        $business = $this->makeBusiness($owner, ['strategy' => 'timeslot']);
        $business->save();

        $service = $this->makeService();

        $business->services()->save($service);

        $bookingStrategy = new BookingStrategy($business->strategy);

        $dateTime = Carbon::now()->addDays(5);

        $appointment = $bookingStrategy->generateAppointment(
            $owner,
            $business,
            $contact,
            $service,
            $dateTime,
            'test comments'
        );

        $this->assertInstanceOf(Appointment::class, $appointment);

        $this->assertEquals($appointment->issuer->id, $owner->id);
        $this->assertEquals($appointment->contact->name, $contact->name);
        $this->assertEquals($appointment->service->name, $service->name);
        $this->assertEquals($appointment->date, $dateTime->toDateString());
        $this->assertEquals($appointment->comments, 'test comments');

        $this->assertEquals(32, strlen($appointment->hash));
    }
}
