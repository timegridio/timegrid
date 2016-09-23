<?php

namespace App\Http\Requests;

use Auth;
use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;

class AlterAppointmentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $appointmentId = $this->get('appointment');
        $businessId = $this->get('business');

        $appointment = Appointment::find($appointmentId);

        $authorize = (auth()->user()->isOwner($businessId) || $appointment->issuer->id == auth()->id());

        logger()->info("Authorize:$authorize");

        return $authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'business'    => 'required|integer',
            'appointment' => 'required|integer',
            'action'      => 'required|in:confirm,cancel,serve',
            'widget'      => 'required|in:row,panel',
        ];
    }
}
