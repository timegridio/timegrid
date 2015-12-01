<?php

namespace App\Http\Controllers;

use Widget;
use Notifynder;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterAppointmentRequest;

/**
 * ToDo:
 *     - Access auth()->ith constructor dependency injection
 *     - Access Appointments with Appointments repository injected dependency
 *     - Access Notifynder with constructor dependency
 *     - Move switches to proper responsibility class
 */

class BookingController extends Controller
{
    /**
     * post Action for booking
     *
     * @param  AlterAppointmentRequest $request
     * @return JSON                    Action result object
     */
    public function postAction(AlterAppointmentRequest $request)
    {
        $this->log->info(__METHOD__);

        $issuer = auth()->user();
        $businessId = $request->input('business');
        $appointmentId = $request->input('appointment');
        $action = $request->input('action');
        $widget = $request->input('widget');

        $this->log->info("AJAX postAction.request:[issuer:$issuer->email, action:$action, business:$businessId, appointment:$appointmentId]");

        $appointment = Appointment::find($appointmentId);

        switch ($action) {
            case 'annulate':
                $appointment->doAnnulate();
                break;
            case 'confirm':
                $appointment->doConfirm();
                break;
            case 'serve':
                $appointment->doServe();
                break;
            default:
                # Ignore Invalid Action
                $this->log->warning('Invalid Action request');
                break;
        }

        /**
         * Widgets MUST be rendered before being returned on Response
         * as they need to be interpreted as HTML
         *
         */
        switch ($widget) {
            case 'row':
                $html = Widget::AppointmentsTableRow(['appointment' => $appointment, 'user' => auth()->user()])->render();
                break;
            case 'panel':
            default:
                $html = Widget::AppointmentPanel(['appointment' => $appointment, 'user' => auth()->user()])->render();
                break;
        }

        $appointmentPresenter = $appointment->getPresenter();
        // TODO: It is probably possible to move Notifynder to a more proper place
        $date = $appointment->start_at->toDateString();
        $code = $appointmentPresenter->code();
        Notifynder::category('appointment.'.$action)
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('code', 'action', 'date'))
                   ->send();

        $this->log->info("postAction.response:[appointment:{$appointment->toJson()}]");
        return response()->json(['code' => 'OK', 'html' => $html]);
    }
}
