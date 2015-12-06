<?php

namespace App\Handlers\Events;

use App\Events\NewRegisteredUser;
use Illuminate\Support\Facades\Mail;

class SendMailUserWelcome
{
    /**
     * Handle the event.
     *
     * @param NewRegisteredUser $event
     *
     * @return void
     */
    public function handle(NewRegisteredUser $event)
    {
        logger()->info('Handle NewRegisteredUser.SendMailUserWelcome()');
        $locale = app()->getLocale();

        //////////////////
        // FOR REFACTOR //
        //////////////////

        Mail::send("emails.{$locale}.welcome", ['user' => $event->user], function ($mail) use ($event) {
            $mail->to($event->user->email, $event->user->name)
                 ->subject(trans('emails.user.welcome.subject'));
        });
    }
}
