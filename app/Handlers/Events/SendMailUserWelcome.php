<?php

namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewRegisteredUser;
use Log;
use Mail;
use Session;

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
        $locale = Session::get('applocale');
        Mail::send("emails.{$locale}.welcome", ['user' => $event->user], function ($m) use ($event) {
            $m->to('alariva@gmail.com', 'alariva')->subject($event->user->email.': TEST DONT TEST!!!');
        });
    }
}
