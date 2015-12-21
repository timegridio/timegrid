<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterAppointmentRequest;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\Service;
use App\Services\ConciergeService;
use Carbon\Carbon;
use Widget;

class BookingController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var App\Services\ConciergeService
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param ConciergeService $concierge
     */
    public function __construct(ConciergeService $concierge)
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

        logger()->info(sprintf(
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

        logger()->info("postAction.response:[appointment:{$appointment->toJson()}]");

        return response()->json(['code' => 'OK', 'html' => $html]);
    }

    public function getTimes($businessId, $serviceId, $date)
    {
        logger()->info(__METHOD__);
        logger()->info("businessId:$businessId serviceId:$serviceId date:$date");

        $business = Business::findOrFail($businessId);
        $service = Service::findOrFail($serviceId);

        $vacancies = $business->vacancies()->forDate(Carbon::parse($date))->get();

        $times = $this->splitTimes($vacancies, $service);

        return response()->json([
            'business' => $businessId,
            'service'  => [
                'id'       => $service->id,
                'duration' => $service->duration,
            ],
            'date'  => $date,
            'times' => $times,
        ], 200);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function splitTimes($vacancies, $service)
    {
        $times = [];
        foreach ($vacancies as $vacancy) {
            $begin = $vacancy->start_at;

            $testBeginTime = $begin->copy();
            $testEndTime = $begin->copy()->addMinutes($service->duration);

            for ($i = 0; $i <= 24; $i++) {
                $testEndTime = $testBeginTime->copy()->addMinutes($service->duration);
                if ($vacancy->hasRoomBetween($testBeginTime, $testEndTime)) {
                    $times[] = $testBeginTime->timezone($vacancy->business->timezone)->toTimeString();
                }
                $testBeginTime->addMinutes($service->duration);
            }
        }

        return $times;
    }
}
