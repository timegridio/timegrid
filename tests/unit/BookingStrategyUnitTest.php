<?php

use App\User;
use App\Business;
use App\Contact;
use App\Service;
use App\Vacancy;
use App\BookingStrategy;
use App\BookingDateslotStrategy;
use App\BookingTimeslotStrategy;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingStrategyUnitTest extends TestCase
{
    use DatabaseTransactions;

    protected $business;

    /**
     * Test make a valid reservation for a contact
     * @return [type] [description]
     */
    public function testMakeValidBooking()
    {
        /* Setup Stubs */
        $user = factory(User::class)->create();
        $business = factory(Business::class)->create();
        $service = factory(Service::class)->make();
        $business->services()->save($service);
        $vacancy = factory(Vacancy::class)->make();
        $vacancy->business()->associate($business);
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);
        $contact = factory(Contact::class)->create();
        $business->contacts()->save($contact);

        /* Perform Test */
        $bookingStrategy = new BookingStrategy($business->strategy);

        $data = [];
        $data['issuer_id'] = $user->id;
        $data['contact_id'] = $contact->id;
        $data['business_id'] = $business->id;
        $data['service_id'] = $service->id;
        $data['_date'] = $vacancy->date;
        $data['duration'] = 0;

        $appointment = $bookingStrategy->makeReservation($user, $business, $data);
        $appointment->save();
        $this->assertEquals(true, $appointment->exists);
    }

    /**
     * Test attempt a reservation for a contact for no vacancies
     * @return [type] [description]
     */
    public function testAttemptBookingForNoVacancy()
    {
        /* Setup Stubs */
        $user = factory(User::class)->create();
        $business = factory(Business::class)->create();
        $service = factory(Service::class)->make();
        $business->services()->save($service);
        $vacancy = factory(Vacancy::class)->make();
        $vacancy->business()->associate($business);
        $vacancy->service()->associate($service);
        $business->vacancies()->save($vacancy);
        $contact = factory(Contact::class)->create();
        $business->contacts()->save($contact);

        /* Perform Test */
        $bookingStrategy = new BookingStrategy($business->strategy);

        $data = [];
        $data['issuer_id'] = $user->id;
        $data['contact_id'] = $contact->id;
        $data['business_id'] = $business->id;
        $data['service_id'] = $service->id;
        $data['_date'] = date('Y-m-d', strtotime($vacancy->date . ' +1 day'));
        $data['duration'] = 0;

        $appointment = $bookingStrategy->makeReservation($user, $business, $data);
        if($canBook = $vacancy->holdsAppointment($appointment));
        $this->assertEquals(false, $canBook);
    }
}
