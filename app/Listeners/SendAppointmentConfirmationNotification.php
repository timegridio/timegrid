<?php

namespace App\Listeners;

use App\Events\AppointmentWasConfirmed;
use App\TG\TransMail;
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
        logger()->info(__METHOD__);

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        Notifynder::category('appointment.confirm')
                   ->from('App\Models\User', $event->user->id)
                   ->to('Timegridio\Concierge\Models\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName', 'code', 'date'))
                   ->send();

        if ($event->appointment->business->pref('disable_outbound_mailing')) {
            return;
        }

        /////////////////
        // Send emails //
        /////////////////

        // Mail to User
        $params = [
            'user'         => $event->user,
            'appointment'  => $event->appointment,
            'userName'     => $event->appointment->contact->firstname,
            'businessName' => $businessName,
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $event->appointment->contact->email,
        ];
        $this->transmail->locale($event->appointment->business->locale)
                        ->timezone($event->user->pref('timezone'))
                        ->template('user.appointment-confirmation.notification')
                        ->subject('user.appointment-confirmation.subject', compact('businessName'))
                        ->send($header, $params);
    }
}
