<?php

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppointmentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @covers \App\Models\Appointment::user
     * @test
     */
    public function it_gets_the_contact_user_of_appointment()
    {
        $user = $this->makeUser();
        $user->save();

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
        $issuer = $this->makeUser();
        $issuer->save();

        $contact = $this->makeContact();
        $contact->save();

        $business = $this->makeBusiness($issuer);
        $business->save();

        $appointment = $this->makeAppointment($business, $issuer, $contact);
        $appointment->save();

        $appointmentDuplicate = $this->makeAppointment($business, $issuer, $contact);

        $this->assertTrue($appointmentDuplicate->duplicates());
    }

    /////////////
    // HELPERS //
    /////////////

    private function makeUser()
    {
        $user = factory(User::class)->make();
        $user->email = 'guest@example.org';
        $user->password = bcrypt('demoguest');

        return $user;
    }

    private function makeAppointment(Business $business, User $issuer, Contact $contact)
    {
        $appointment = factory(Appointment::class)->make();
        $appointment->contact()->associate($contact);
        $appointment->issuer()->associate($issuer);
        $appointment->business()->associate($business);

        return $appointment;
    }

    private function makeContact(User $user = null)
    {
        $contact = factory(Contact::class)->make();
        if ($user) {
            $contact->user()->associate($user);
        }

        return $contact;
    }

    private function makeBusiness(User $owner, $overrides = [])
    {
        $business = factory(Business::class)->make($overrides);
        $business->save();
        $business->owners()->attach($owner);

        return $business;
    }
}
