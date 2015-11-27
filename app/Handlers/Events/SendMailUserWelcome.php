<?php

namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewRegisteredUser;
use Log;
use Mail;
use App;

class SendMailUserWelcome
{
    /**
     * Log facade
     * @var log
     */
    protected $log;

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
    public function __construct(Log $log, Mail $mail, App $app)
    {
        $this->log  = $log;
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
        $this->log->info('Handle NewRegisteredUser.SendMailUserWelcome()');
        $locale = $this->app->getLocale();
        $this->mail->send("emails.{$locale}.welcome", ['user' => $event->user], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)->subject(trans('emails.user.welcome.subject'));
        });
    }
}
