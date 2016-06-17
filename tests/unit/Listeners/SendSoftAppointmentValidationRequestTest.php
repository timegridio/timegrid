<?php

use App\Events\NewSoftAppointmentWasBooked;
use App\Listeners\SendSofAppointmentValidationRequest;
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
    public function handle()
    {
        $this->transmail->shouldReceive('locale')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('timezone')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('template')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('subject')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('send')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('success')->andReturn(true);

        $listener = new SendSofAppointmentValidationRequest($this->transmail);

        $listener->handle(new NewSoftAppointmentWasBooked($this->appointment));

        $this->assertTrue($this->transmail->success());
    }
}
