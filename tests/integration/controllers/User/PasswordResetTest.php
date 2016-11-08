<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordResetTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser;

    /**
     * User.
     *
     * @var App\Models\User
     */
    protected $user;

    /**
     * @test
     */
    public function it_rejects_unregistered_email()
    {
        $this->visit(route('user.agenda'));

        $this->seePageIs('/login');

        $this->click('Forgot password');

        $this->type('unregistered@example.org', 'email');

        $this->press('Send me the reset link');

        $this->see('We can\'t find a user with that e-mail address.');
    }

    /**
     * @test
     */
    public function it_provides_password_reset_to_registered_email()
    {
        $this->user = $this->createUser();

        $this->visit(route('user.agenda'));

        $this->seePageIs('/login');

        $this->click('Forgot password');

        $this->type($this->user->email, 'email');

        $this->press('Send me the reset link');

        $this->see('We have e-mailed your password reset link');
    }

    /**
     * @test
     */
    public function it_resets_the_password()
    {
        $this->it_provides_password_reset_to_registered_email();

        $passwordReset = DB::table('password_resets')->select('token')->where('email', $this->user->email)->first();

        $this->visit('/password/reset/'.$passwordReset->token);

        $this->type($this->user->email, 'email');
        $this->type('nevermind', 'password');
        $this->type('nevermind', 'password_confirmation');

        $this->press('Reset password');

        $this->assertEquals($this->user->email, auth()->user()->email);
    }
}
