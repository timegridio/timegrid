<?php

namespace App\Handlers\Events;

use App\Events\AppointmentWasConfirmed;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Support\Facades\Mail;

class SendAppointmentConfirmationNotification
{
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
            'toMail'  => $event->appointment->contact->email,
            'toName'  => $event->appointment->contact->firstname,
            'subject' => trans('emails.user.appointment.confirmed.subject', ['business' => $event->appointment->business->name]),
        ];
        $this->sendMail($header, $params, 'appointments.user._confirmed');
    }

    /**
     * Load localized email view and send email.
     *
     * @param  array  $header
     * @param  array  $params
     * @param  string $view   Tail of view path after locale
     * @param  string $locale
     *
     * @return void
     *
     * @throws  \Exception 'Email view does not exist'
     */
    protected function sendMail(array $header, array $params, $view, $locale = null)
    {
        if ($locale === null) {
            $locale = app()->getLocale();
        }

        $view = "emails.{$locale}.{$view}";
        if (!view()->exists($view)) {
            throw new \Exception('Email view does not exist');
        }

        Mail::send($view, $params, function ($mail) use ($header) {
            $mail->to($header['toMail'], $header['toName'])->subject($header['subject']);
        });
    }
}
