<?php

namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewRegisteredUser;
use Log;
use Mail;
use Session;
use App;

class SendMailUserWelcome
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewRegisteredUser  $event
     * @return void
     */
    public function handle(NewRegisteredUser $event)
    {
        Log::info('Handle NewRegisteredUser.SendMailUserWelcome()');
        $locale = App::getLocale();
        Mail::send("emails.{$locale}.welcome", ['user' => $event->user], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)->subject(trans('emails.welcome.subject'));
        });
    }
}
