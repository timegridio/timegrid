<?php

namespace App\Handlers\Events;

use App;
use App\Events\NewRegisteredUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailUserWelcome
{
    /**
     * Mail facade
     * @var mail
     */
    protected $mail;

    /**
     * App facade
     * @var app
     */
    protected $app;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(Mail $mail, App $app)
    {
        $this->mail = $mail;
        $this->app  = $app;
    }

    /**
     * Handle the event.
     *
     * @param  NewRegisteredUser  $event
     * @return void
     */
    public function handle(NewRegisteredUser $event)
    {
        logger()->info('Handle NewRegisteredUser.SendMailUserWelcome()');
        $locale = $this->app->getLocale();
        $this->mail->send("emails.{$locale}.welcome", ['user' => $event->user], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)->subject(trans('emails.user.welcome.subject'));
        });
    }
}
