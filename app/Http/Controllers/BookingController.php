<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\AlterAppointmentRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Appointment;
use App\Business;
use Notifynder;
use Session;
use Carbon;
use Widget;
use Event;
use Auth;
use URL;
use Log;

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
        Log::info('BookingController: postAction');
        $issuer = Auth::user();
        $businessId = $request->input('business');
        $appointmentId = $request->input('appointment');
        $action = $request->input('action');
        $widget = $request->input('widget');

        Log::info("AJAX postAction.request:[issuer:$issuer->email, action:$action, business:$businessId, appointment:$appointmentId]");

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
                Log::warning('Invalid Action request');
                break;
        }

        /**
         * Widgets MUST be rendered before being returned on Response
         * as they need to be interpreted as HTML
         * 
         */

        $appointmentPresenter = $appointment->getPresenter();
        switch ($widget) {
            case 'row':
                $html = Widget::AppointmentsTableRow(['appointment' => $appointmentPresenter, 'user' => \Auth::user()])->render();
                break;
            case 'panel':
            default:
                $html = Widget::AppointmentPanel(['appointment' => $appointment, 'user' => \Auth::user()])->render();
                break;
        }

        // TODO: It is probably possible to move Notifynder to a more proper place
        $date = $appointment->start_at->toDateString();
        $code = $appointmentPresenter->code();
        Notifynder::category('appointment.'.$action)
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('code', 'action', 'date'))
                   ->send();

        Log::info("postAction.response:[appointment:{$appointment->toJson()}]");
        return response()->json(['code' => 'OK', 'html' => $html]); // TODO: Safe to remove .''
    }
}
