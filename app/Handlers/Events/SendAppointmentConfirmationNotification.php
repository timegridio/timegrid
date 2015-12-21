<?php

namespace App\Handlers\Events;

use App\Events\AppointmentWasConfirmed;
use App\TransMail;
use Fenos\Notifynder\Facades\Notifynder;

class SendAppointmentConfirmationNotification
{
    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    /**
     * Handle the event.
     *
     * @param AppointmentWasConfirmed $event
     *
     * @return void
     */
    public function handle(AppointmentWasConfirmed $event)
    {
        logger()->info('Handle AppointmentWasConfirmed.SendBookingNotification()');

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        Notifynder::category('appointment.confirm')
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
            'name'  => $event->appointment->contact->firstname,
            'email' => $event->appointment->contact->email,
        ];
        $this->transmail->locale($event->appointment->business->locale)
                        ->template('appointments.user._confirmed')
                        ->subject('user.appointment.confirmed.subject', ['business' => $event->appointment->business->name])
                        ->send($header, $params);
    }
}
