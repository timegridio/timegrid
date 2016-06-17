<?php

namespace App\Listeners;

use App\Events\NewSoftAppointmentWasBooked;
use App\TransMail;

class SendSoftAppointmentValidationRequest
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
    public function handle(NewSoftAppointmentWasBooked $event)
    {
        logger()->info(__METHOD__);

        $timezone = $event->appointment->business->timezone;
        $business = $event->appointment->business->name;
        $businessSlug = $event->appointment->business->slug;
        $locale = $event->appointment->business->locale;
        $email = $event->appointment->contact->email;
        $code = $event->appointment->code;

        ////////////////////////////////////////////////////
        // Send Soft Appointment Validation Request Email //
        ////////////////////////////////////////////////////

        $params = [
            'appointment' => $event->appointment,
            'link'        => $this->generateLink($businessSlug, $code, $email),
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $email,
        ];

        return $this->transmail
                    ->locale($locale)
                    ->timezone($timezone)
                    ->template('appointments.user._validate')
                    ->subject('user.appointment.validate.subject', compact('business'))
                    ->send($header, $params);
    }

    protected function generateLink($business, $code, $email)
    {
        return link_to_route('user.booking.validate', null, compact('business', 'code', 'email'));
    }
}
