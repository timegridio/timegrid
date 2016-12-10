<?php

namespace App\Listeners;

use App\Events\NewSoftAppointmentWasBooked;
use App\TG\TransMail;

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
        $businessName = $event->appointment->business->name;
        $businessSlug = $event->appointment->business->slug;
        $locale = $event->appointment->business->locale;
        $email = $event->appointment->contact->email;
        $code = $event->appointment->code;

        if ($event->appointment->business->pref('disable_outbound_mailing')) {
            return;
        }

        ////////////////////////////////////////////////////
        // Send Soft Appointment Validation Request Email //
        ////////////////////////////////////////////////////

        $params = [
            'appointment'  => $event->appointment,
            'link'         => $this->generateLink($businessSlug, $code, $email),
            'businessName' => $businessName,
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $email,
        ];

        return $this->transmail
                    ->locale($locale)
                    ->timezone($timezone)
                    ->template('guest.appointment-validation.validation')
                    ->subject('guest.appointment-validation.subject', compact('businessName'))
                    ->send($header, $params);
    }

    protected function generateLink($business, $code, $email)
    {
        return link_to_route('user.booking.validate', null, compact('business', 'code', 'email'));
    }
}
