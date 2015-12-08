<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterAppointmentRequest;
use App\Models\Appointment;
use App\Services\ConciergeService;
use Notifynder;
use Widget;

/**
 * FOR REFACTOR:
 *     - Access auth()->ith constructor dependency injection
 *     - Access Appointments with Appointments repository injected dependency
 *     - Access Notifynder with constructor dependency
 *     - Move switches to proper responsibility class.
 */
class BookingController extends Controller
{
    /**
     * [$concierge description]
     *
     * @var [type]
     */
    private $concierge;

    /**
     * [__construct description]
     *
     * @param ConciergeService $concierge [description]
     */
    public function __construct(ConciergeService $concierge)
    {
        $this->concierge = $concierge;

        parent::__construct();
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
        $this->log->info(__METHOD__);

        //////////////////
        // FOR REFACOTR //
        //////////////////

        $issuer = auth()->user();
        $businessId = $request->input('business');
        $appointment = Appointment::findOrFail($request->input('appointment'));
        $action = $request->input('action');
        $widgetType = $request->input('widget');

        ///////////////////////////////////
        // TODO: AUTHORIZATION GOES HERE //
        ///////////////////////////////////
        // AUTHORIZE:
        //  (A) auth()->user() is owner of $business
        // OR
        //  (B) auth()->user() is issuer of $appointment

        $this->log->info(sprintf(
            'postAction.request:[issuer:%s, action:%s, business:%s, appointment:%s]',
            $issuer->email,
            $action,
            $businessId,
            $appointment->id
        ));

        try {
            $appointment = $this->concierge->requestAction(auth()->user(), $appointment, $action);
        } catch (\Exception $e) {
            return response()->json(['code' => 'ERROR', 'html' => '']);
        }

        $contents = ['appointment' => $appointment, 'user' => auth()->user()];

        $viewKey = "widgets.appointment.{$widgetType}._body";
        if (!view()->exists($viewKey)) {
            return response()->json(['code' => 'ERROR', 'html' => '']);
        }
        
        // Widgets MUST be rendered before being returned on Response as they need to be interpreted as HTML
        $html = view($viewKey, $contents)->render();

        $this->log->info("postAction.response:[appointment:{$appointment->toJson()}]");
        return response()->json(['code' => 'OK', 'html' => $html]);
    }
}
