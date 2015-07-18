<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Business;
use App\Appointment;
use Route;

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
        $user = \Auth::user();

        $business = Business::find($businessId);
        $appointment = Appointment::find($appointmentId);

        $result = ($appointment->issuer->id == $user->id) || $user->isOwner($business);
        \Log::info("Authorize AlterAppointmentRequest for user:{$user->id} appointment:$appointmentId business:$businessId result:$result");
        return $result;
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
