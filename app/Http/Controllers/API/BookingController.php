<?php

namespace App\Http\Controllers\API;

use App\Events\AppointmentWasCanceled;
use App\Events\AppointmentWasConfirmed;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterAppointmentRequest;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;

class BookingController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param Timegridio\Concierge\Concierge
     */
    public function __construct(Concierge $concierge)
    {
        parent::__construct();

        $this->concierge = $concierge;
    }

    /**
     * post Action for booking.
     *
     * @param AlterAppointmentRequest $request
     *
     * @return JSON Action result object
     */
    public function postAction(AlterAppointmentRequest $request)
    {
        logger()->info(__METHOD__);

        //////////////////
        // FOR REFACOTR //
        //////////////////

        $issuer = auth()->user();
        $business = Business::findOrFail($request->input('business'));
        $appointment = Appointment::findOrFail($request->input('appointment'));
        $action = $request->input('action');
        $widgetType = $request->input('widget');

        /////////////////////////////////////////////
        // AUTHORIZATION : AlterAppointmentRequest //
        /////////////////////////////////////////////
        //  (A) auth()->user() is owner of $business
        // OR
        //  (B) auth()->user() is issuer of $appointment

        logger()->info(sprintf(
            'postAction.request:[issuer:%s, action:%s, business:%s, appointment:%s]',
            $issuer->email,
            $action,
            $business->id,
            $appointment->id
        ));

        $this->concierge->business($business);

        $appointmentManager = $this->concierge->booking()->appointment($appointment->hash);

        switch ($action) {
            case 'cancel':
                $appointment = $appointmentManager->cancel();
                event(new AppointmentWasCanceled($issuer, $appointment));
                break;
            case 'confirm':
                $appointment = $appointmentManager->confirm();
                event(new AppointmentWasConfirmed($issuer, $appointment));
                break;
            case 'serve':
                $appointment = $appointmentManager->serve();
                break;
            default:
                # code...
                break;
        }

        $contents = [
            'appointment' => $appointment->load('contact'),
            'user'        => auth()->user(),
            ];

        $viewKey = "widgets.appointment.{$widgetType}._body";
        if (!view()->exists($viewKey)) {
            return response()->json(['code' => 'ERROR', 'html' => '']);
        }

        // Widgets MUST be rendered before being returned on Response as they need to be interpreted as HTML
        $html = view($viewKey, $contents)->render();

        logger()->info("postAction.response:[appointment:{$appointment->toJson()}]");

        return response()->json(['code' => 'OK', 'html' => $html]);
    }
}
