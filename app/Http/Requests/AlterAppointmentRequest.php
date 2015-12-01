<?php

namespace App\Http\Requests;

use Auth;
use App\Models\Business;
use App\Models\Appointment;
use App\Http\Requests\Request;

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
        $issuer = auth()->user();

        $business = Business::find($businessId);
        $appointment = Appointment::find($appointmentId);

        $authorize = ($appointment->issuer->id == $issuer->id) || $issuer->isOwner($business);
        # \Log::info("Authorize AlterAppointmentRequest for issuer:{$issuer->id} appointment:$appointmentId business:$businessId authorize:$authorize");
        return $authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
