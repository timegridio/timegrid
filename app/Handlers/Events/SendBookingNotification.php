<?php

namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewBooking;
use Notifynder;
use Log;
use Mail;
use App;

class SendBookingNotification
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
     * @param  NewBooking  $event
     * @return void
     */
    public function handle(NewBooking $event)
    {
        Log::info('Handle NewBooking.SendBookingNotification()');

        $business_name = $event->appointment->business->name;
        Notifynder::category('appointment.reserve')
                   ->from('App\User', $event->user->id)
                   ->to('App\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        $locale = App::getLocale();
        Mail::send("emails.{$locale}.appointments._new", ['user' => $event->user, 'appointment' => $event->appointment], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)->subject(trans('emails.appointment.reserved.subject'));
        });
    }
}
