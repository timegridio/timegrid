<?php

namespace App\Handlers\Events;

use App\Events\NewAppointmentWasBooked;
use App\TransMail;
use Fenos\Notifynder\Facades\Notifynder;

class SendBookingNotification
{
    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    /**
     * Handle the event.
     *
     * @param NewAppointmentWasBooked $event
     *
     * @return void
     */
    public function handle(NewAppointmentWasBooked $event)
    {
        logger()->info('Handle NewAppointmentWasBooked.SendBookingNotification()');

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        Notifynder::category('appointment.reserve')
                   ->from('App\Models\User', $event->user->id)
                   ->to('App\Models\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName', 'code', 'date'))
                   ->send();

        /////////////////
        // Send emails //
        /////////////////

        // Mail to User
        $params = [
            'user'        => $event->user,
            'appointment' => $event->appointment,
        ];
        $header = [
            'name'  => $event->user->name,
            'email' => $event->user->email,
        ];
        $this->transmail->locale($event->appointment->business->locale)
                        ->template('appointments.user._new')
                        ->subject('user.appointment.reserved.subject')
                        ->send($header, $params);

        // Mail to Owner
        $params = [
            'user'        => $event->appointment->business->owner(),
            'appointment' => $event->appointment,
        ];
        $header = [
            'name'  => $event->appointment->business->owner()->name,
            'email' => $event->appointment->business->owner()->email,
        ];
        $this->transmail->locale($event->appointment->business->locale)
                        ->template('appointments.manager._new')
                        ->subject('manager.appointment.reserved.subject')
                        ->send($header, $params);
    }
}
