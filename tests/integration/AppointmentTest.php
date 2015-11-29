<?php

use App\User;
use App\Contact;
use App\Business;
use App\Appointment;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppointmentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @covers \App\Appointment::user
     * @test
     */
    public function it_gets_the_contact_user_of_appointment()
    {
        $user = $this->makeUser();
        $contact = $this->makeContact($user);
        $appointment = $this->makeAppointment($user, $contact);

        $this->assertEquals($user, $appointment->user());
    }

    /**
     * @covers \App\Appointment::user
     * @test
     */
    public function it_gets_no_user_from_contact_of_appointment()
    {
        $issuer = $this->makeUser();
        $contact = $this->makeContact();
        $appointment = $this->makeAppointment($issuer, $contact);

        $this->assertNull($appointment->user());
    }

    private function makeUser()
    {
        $user = factory(User::class)->make();
        $user->email = 'guest@example.org';
        $user->password = bcrypt('demoguest');

        return $user;
    }

    private function makeAppointment(User $issuer, Contact $contact)
    {
        $appointment = factory(Appointment::class)->make();
        $appointment->contact()->associate($contact);
        $appointment->issuer()->associate($issuer);

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
}
