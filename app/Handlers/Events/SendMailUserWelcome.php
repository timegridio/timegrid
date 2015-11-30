<?php

namespace App\Handlers\Events;

use App\Events\NewRegisteredUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailUserWelcome
{
    /**
     * Handle the event.
     *
     * @param  NewRegisteredUser  $event
     * @return void
     */
    public function handle(NewRegisteredUser $event)
    {
        logger()->info('Handle NewRegisteredUser.SendMailUserWelcome()');
        $locale = app()->getLocale();
        Mail::send("emails.{$locale}.welcome", ['user' => $event->user], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)->subject(trans('emails.user.welcome.subject'));
        });
    }
}
