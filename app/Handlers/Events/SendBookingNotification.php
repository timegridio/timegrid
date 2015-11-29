<?php

namespace App\Handlers\Events;

use App\Events\NewBooking;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingNotification
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
     * @param  NewBooking  $event
     * @return void
     */
    public function handle(NewBooking $event)
    {
        logger()->info('Handle NewBooking.SendBookingNotification()');

        $code = $event->appointment->getPresenter()->code();
        $date = $event->appointment->start_at->toDateString();
        $business_name = $event->appointment->business->name;
        
        Notifynder::category('appointment.reserve')
                   ->from('App\User', $event->user->id)
                   ->to('App\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name', 'code', 'date'))
                   ->send();

        $locale = $this->app->getLocale();
        $this->mail->send("emails.{$locale}.appointments.user._new", ['user' => $event->user, 'appointment' => $event->appointment->getPresenter()], function ($m) use ($event) {
            $m->to($event->user->email, $event->user->name)->subject(trans('emails.user.appointment.reserved.subject'));
        });
        $this->mail->send("emails.{$locale}.appointments.manager._new", ['user' => $event->appointment->business->owner(), 'appointment' => $event->appointment->getPresenter()], function ($m) use ($event) {
            $m->to($event->appointment->business->owner()->email, $event->appointment->business->owner()->name)->subject(trans('emails.manager.appointment.reserved.subject'));
        });
    }
}
