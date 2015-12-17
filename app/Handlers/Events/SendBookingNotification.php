<?php

namespace App\Handlers\Events;

use App\Events\NewAppointmentWasBooked;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Support\Facades\Mail;

class SendBookingNotification
{
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
            'toMail'  => $event->user->email,
            'toName'  => $event->user->name,
            'subject' => trans('emails.user.appointment.reserved.subject'),
        ];
        $this->sendMail($header, $params, 'appointments.user._new');

        // Mail to Owner
        $params = [
            'user'        => $event->appointment->business->owner(),
            'appointment' => $event->appointment,
        ];
        $header = [
            'toMail'  => $event->appointment->business->owner()->email,
            'toName'  => $event->appointment->business->owner()->name,
            'subject' => trans('emails.manager.appointment.reserved.subject'),
        ];
        $this->sendMail($header, $params, 'appointments.manager._new', $event->appointment->business->locale);
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

        mailer()->send($view, $params, function ($mail) use ($event) {
            $mail->to($header['toMail'], $header['toName'])->subject($header['subject']);
        });
    }
}
