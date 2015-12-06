<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlterAppointmentRequest;
use App\Models\Appointment;
use App\Presenters\AppointmentPresenter;
use Notifynder;
use Widget;

/**
 * FOR REFACTOR:
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

        //////////////////
        // FOR REFACOTR //
        //////////////////

        $issuer = auth()->user();
        $businessId = $request->input('business');
        $appointmentId = $request->input('appointment');
        $action = $request->input('action');
        $widget = $request->input('widget');

        $this->log->info(sprintf(
            "AJAX postAction.request:[issuer:%s, action:%s, business:%s, appointment:%s]",
            $issuer->email,
            $action,
            $businessId,
            $appointmentId
        ));

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
                // Ignore Invalid Action
                $this->log->warning('Invalid Action request');
                return response()->json(['code' => 'ERROR', 'html' => '']);
                break;
        }

        /**
         * Widgets MUST be rendered before being returned on Response
         * as they need to be interpreted as HTML
         */
        switch ($widget) {
            case 'row':
                $buttons = '';
                $html = view('widgets.appointment.row._body', ['appointment' => $appointment, 'user' => auth()->user()])->render();
                break;
            case 'panel':
            default:
                $html = view('widgets.appointment.panel._body', ['appointment' => $appointment, 'user' => auth()->user()])->render();
                break;
        }

        $date = $appointment->date;
        $code = $appointment->code;
        Notifynder::category('appointment.'.$action)
                   ->from('App\Models\User', $issuer->id)
                   ->to('App\Models\Business', $appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('code', 'action', 'date'))
                   ->send();

        $this->log->info("postAction.response:[appointment:{$appointment->toJson()}]");
        return response()->json(['code' => 'OK', 'html' => $html]);
    }
}
