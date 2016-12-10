<?php

use App\Events\NewSoftAppointmentWasBooked;
use App\Listeners\SendSoftAppointmentValidationRequest;
use App\TG\TransMail;

class SendSoftAppointmentValidationRequestTest extends TestCase
{
    use CreateAppointment;

    public function setUp()
    {
        parent::setUp();
        $this->transmail = Mockery::mock(TransMail::class);
        $this->appointment = $this->createAppointment();
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
        $this->appointment->business->pref('disable_outbound_mailing', false);

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

    /**
     * @test
     */
    public function it_skips_sending_a_soft_appointment_validation_request_email()
    {
        $transmailSpy = Mockery::spy(TransMail::class);

        $this->appointment->business->pref('disable_outbound_mailing', true);

        $listener = new SendSoftAppointmentValidationRequest($transmailSpy);

        $listener->handle(new NewSoftAppointmentWasBooked($this->appointment));

        $transmailSpy->shouldNotHaveReceived('send');
    }
}
