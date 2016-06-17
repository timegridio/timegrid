<?php

use App\Events\NewSoftAppointmentWasBooked;
use App\Listeners\SendSoftAppointmentValidationRequest;
use App\TransMail;

class SendSoftAppointmentValidationRequestTest extends TestCase
{
    use CreateBusiness, CreateContact, CreateAppointment;

    public function setUp()
    {
        parent::setUp();
        $this->transmail = Mockery::mock(TransMail::class);
        $this->appointment = $this->createAppointment();

        $this->business = $this->createBusiness();
        $this->contact = $this->createContact();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function it_sends_a_soft_appointment_validation_request_email()
    {
        $this->transmail->shouldReceive('locale')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('timezone')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('template')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('subject')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('send')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('success')->andReturn(true);

        $listener = new SendSoftAppointmentValidationRequest($this->transmail);

        $listener->handle(new NewSoftAppointmentWasBooked($this->appointment));

        $this->assertTrue($this->transmail->success());
    }
}
