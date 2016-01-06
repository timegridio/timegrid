<?php

use App\TransMail;

class TransMailTest extends TestCase
{
    /**
     * @var Mail
     */
    protected $mail = null;

    /**
     * @var TransMail
     */
    protected $transmail = null;

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @test
     */
    public function it_sends_a_localized_email()
    {
        $this->arrangeScenario();

        $this->mail->shouldReceive('send');

        $this->transmail->locale('en_US.utf8')
                        ->template('welcome')
                        ->subject('welcome')
                        ->send($this->header, $this->params);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function it_throws_exception_on_unexisting_view()
    {
        $this->arrangeScenario();

        $this->transmail->locale('en_US.utf8')
                        ->template('!!!UNEXISTING!!!')
                        ->subject('welcome')
                        ->send($this->header, $this->params);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function arrangeScenario()
    {
        $this->mail = new Mail();

        $this->transmail = Mockery::mock(new TransMail($this->mail));

        $this->header = [
            'email' => 'test@example.org',
            'name'  => 'Test',
        ];

        $this->params = [
            'example_field_one' => 'beer anytime you damn well, please',
            'example_field_two' => 'I am your father',
        ];
    }
}
