<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\AlterAppointmentRequest;
use App\Appointment;
use App\Business;
use Auth;
use Notifynder;
use Carbon;
use Session;
use URL;
use Event;
use Log;

class BookingController extends Controller
{
 
   public function postAction(Request $request)
    {
        $issuer = Auth::user();
        $businessId = $request->input('business');
        $appointmentId = $request->input('appointment');
        $action = $request->input('action');
        $widget = $request->input('widget');

        Log::info("AJAX postAction.request:[action:$action, business:$businessId, appointment:$appointmentId]");

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
                # code...
                break;
        }

        switch ($widget) {
            case 'row':
                $html = $appointment->widget()->row();
                break;
            case 'panel':
            default:
                $html = $appointment->widget()->panel();
                break;
        }

        $date = $appointment->start_at->toDateString();
        $code = substr($appointment->code, 0, 4);
        Notifynder::category('appointment.'.$action)
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('code', 'action', 'date'))
                   ->send();

        Log::info("postAction.response:[appointment:{$appointment->toJson()}]");
        return response()->json(['code' => 'OK', 'html' => $html.'']);
    }
}
