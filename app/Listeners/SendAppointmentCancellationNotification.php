<?php

namespace App\Listeners;

use App\Events\AppointmentWasCanceled;
use App\TransMail;
use Fenos\Notifynder\Facades\Notifynder;

class SendAppointmentCancellationNotification
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
    public function handle(AppointmentWasCanceled $event)
    {
        logger()->info(__CLASS__.':'.__METHOD__);

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        Notifynder::category('appointment.cancel')
                   ->from('App\Models\User', $event->user->id)
                   ->to('Timegridio\Concierge\Models\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName', 'code', 'date'))
                   ->send();

        /////////////////
        // Send emails //
        /////////////////

        // Mail to User
        $params = [
            'user'         => $event->user,
            'appointment'  => $event->appointment,
            'businessName' => $businessName,
            'userName'     => $event->appointment->contact->firstname,
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $event->appointment->contact->email,
        ];
        $this->transmail->locale($event->appointment->business->locale)
                        ->timezone($event->user->pref('timezone'))
                        ->template('user.appointment-cancellation.notification')
                        ->subject('user.appointment-cancellation.subject', compact('businessName'))
                        ->send($header, $params);
    }
}
