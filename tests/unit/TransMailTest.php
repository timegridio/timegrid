<?php

use App\TransMail;
use Snowfire\Beautymail\Beautymail;

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

    public function setUp()
    {
        parent::setUp();

        $this->arrangeScenario();
    }

    /**
     * @test
     */
    public function it_sends_a_localized_email()
    {
        $this->mail
             ->shouldReceive('send')
             ->once()
             ->andReturn(true)
             ->shouldReceive('failures')
             ->andReturn(0);

        $this->transmail->locale('en_US.utf8')
                        ->template('user.welcome.welcome')
                        ->subject('user.welcome.subject')
                        ->send($this->header, $this->params);
    }

    /**
     * @test
     */
    public function it_switches_timezone()
    {
        $testTimezone = 'Europe/London';
        
        $return = $this->transmail->switchTimezone($testTimezone);

        $this->assertEquals($return, $this->transmail);

        $return = $this->transmail->timezone($testTimezone);

        $this->assertEquals($return, $this->transmail);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function it_throws_exception_on_unexisting_view()
    {
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
        $this->mail = Mockery::mock(Beautymail::class);

        $this->transmail = new TransMail($this->mail);

        $this->header = [
            'email' => 'test@example.org',
            'name'  => 'Test',
        ];

        $this->params = [
            'example_field_one' => 'beer anytime you damn well, please',
            'example_field_two' => 'Luke, I am your father',
        ];
    }
}
