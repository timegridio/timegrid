<?php

use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use App\Models\User;
use Timegridio\Concierge\Presenters\AppointmentPresenter;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppointmentPresenterTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateContact, CreateBusiness, CreateAppointment;

    protected $user;

    protected $business;

    protected $contact;

    /**
     * @covers App\Presenters\AppointmentPresenter::statusToCssClass
     * @test
     */
    public function it_gets_the_appointment_css_class_for_reserved()
    {
        $this->arrangeScenario();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_RESERVED]
        );

        $presenter = new AppointmentPresenter($appointment);

        $status = $presenter->statusToCssClass;

        $this->assertEquals('warning', $status);
    }

    /**
     * @covers App\Presenters\AppointmentPresenter::statusToCssClass
     * @test
     */
    public function it_gets_the_appointment_css_class_for_confirmed()
    {
        $this->arrangeScenario();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_CONFIRMED]
        );

        $presenter = new AppointmentPresenter($appointment);

        $status = $presenter->statusToCssClass;

        $this->assertEquals('success', $status);
    }

    /**
     * @covers App\Presenters\AppointmentPresenter::statusToCssClass
     * @test
     */
    public function it_gets_the_appointment_css_class_for_annulated()
    {
        $this->arrangeScenario();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_ANNULATED]
        );

        $presenter = new AppointmentPresenter($appointment);

        $status = $presenter->statusToCssClass;

        $this->assertEquals('danger', $status);
    }

    /**
     * @covers App\Presenters\AppointmentPresenter::statusToCssClass
     * @test
     */
    public function it_gets_the_appointment_css_class_for_served()
    {
        $this->arrangeScenario();

        $appointment = $this->makeAppointment(
            $this->business,
            $this->user,
            $this->contact,
            ['status' => Appointment::STATUS_SERVED]
        );

        $presenter = new AppointmentPresenter($appointment);

        $status = $presenter->statusToCssClass;

        $this->assertEquals('default', $status);
    }

    /////////////
    // HELPERS //
    /////////////

    private function arrangeScenario()
    {
        $this->user = $this->makeUser();
        $this->user->save();

        $this->contact = $this->makeContact($this->user);
        $this->contact->save();

        $this->business = $this->makeBusiness($this->user);
        $this->business->save();
    }
}
