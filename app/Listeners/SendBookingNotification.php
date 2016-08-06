<?php

namespace App\Listeners;

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
        logger()->info(__METHOD__);

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        Notifynder::category('appointment.reserve')
                   ->from('App\Models\User', $event->user->id)
                   ->to('Timegridio\Concierge\Models\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName', 'code', 'date'))
                   ->send();

        /////////////////
        // Send emails //
        /////////////////

        $this->sendEmailToContactUser($event);

        $this->sendEmailToOwner($event);
    }

    protected function sendEmailToContactUser($event)
    {
        if (!$user = $event->appointment->contact->user) {
            return false;
        }

        $destinationEmail = $this->getDestinationEmail($user, $event->appointment->contact);

        $params = [
            'user'        => $user,
            'appointment' => $event->appointment,
            'userName'    => $event->appointment->contact->firstname,
        ];
        $header = [
            'name'  => $contact->firstname,
            'email' => $destinationEmail,
        ];
        $email = [
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->appointment->business->locale,
            'timezone' => $user->pref('timezone'),
            'template' => 'user.appointment-notification.notification',
            'subject'  => 'user.appointment-notification.subject',
        ];
        $this->sendemail($email);
    }

    protected function sendEmailToOwner($event)
    {
        $params = [
            'user'        => $event->appointment->business->owner(),
            'appointment' => $event->appointment,
            'ownerName'   => $event->appointment->business->owner()->name,
        ];
        $header = [
            'name'  => $event->appointment->business->owner()->name,
            'email' => $event->appointment->business->owner()->email,
        ];
        $email = [
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->appointment->business->locale,
            'timezone' => $event->appointment->business->owner()->pref('timezone'),
            'template' => 'manager.appointment-notification.notification',
            'subject'  => 'manager.appointment-notification.subject',
        ];
        $this->sendemail($email);
    }

    protected function sendEmail($email)
    {
        extract($email);

        $this->transmail->locale($locale)
                        ->timezone($timezone)
                        ->template($template)
                        ->subject($subject)
                        ->send($header, $params);
    }

    protected function getDestinationEmail(User $user, Contact $contact)
    {
        return $contact->email ?: $user->email;
    }
}
