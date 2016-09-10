<?php

use App\Events\NewUserWasRegistered;
use App\Listeners\SendMailUserWelcome;
use App\TG\TransMail;

class SendMailUserWelcomeTest extends TestCase
{
    use CreateUser;

    public function setUp()
    {
        parent::setUp();
        $this->transmail = Mockery::mock(TransMail::class);

        $this->user = $this->createUser();
    }

    /**
     * @test
     */
    public function it_sends_a_soft_appointment_validation_request_email()
    {
        $this->transmail->shouldReceive('template')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('subject')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('send')->once()->andReturn($this->transmail);
        $this->transmail->shouldReceive('success')->andReturn(true);

        $listener = new SendMailUserWelcome($this->transmail);

        $listener->handle(new NewUserWasRegistered($this->user));

        $this->assertTrue($this->transmail->success());
    }
}
