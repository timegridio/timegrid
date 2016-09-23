<?php

use App\TG\Business\Token as BusinessToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Timegridio\Concierge\Models\Appointment;

class ICalControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;
    use CreateUser, CreateBusiness, CreateContact, CreateAppointment;

    /**
     * @var Timegridio\Concierge\Models\Business
     */
    protected $business;

    /**
     * @var App\Models\User
     */
    protected $owner;

    /**
     * @var Timegridio\Concierge\Models\Appointment
     */
    protected $appointment;

    /**
     * @test
     */
    public function it_provides_a_downloadable_ical_access()
    {
        $this->arrangeBusinessWithOwner();

        $businessToken = new BusinessToken($this->business);

        $token = $businessToken->generate();

        $this->call('get', route('api.business.ical.download', [$this->business, $token]));

        $this->see('BEGIN:VCALENDAR');
        $this->see("PRODID:{$this->business->slug}");
    }

    /**
     * @test
     */
    public function it_rejects_unauthorized_ical_access()
    {
        $this->arrangeBusinessWithOwner();

        $this->call('get', route('api.business.ical.download', [$this->business, 'invalid']));

        $this->assertResponseStatus(403);
    }

    //////////////////////
    // Scenario Helpers //
    //////////////////////

    protected function arrangeBusinessWithOwner()
    {
        $this->owner = $this->createUser();

        $this->business = $this->createBusiness();

        $this->business->owners()->save($this->owner);

        $this->appointment = $this->createAppointments(10, [
            'business_id' => $this->business->id,
            'issuer_id'   => $this->owner->id,
            'status'      => Appointment::STATUS_CONFIRMED,
            ]);
    }
}
