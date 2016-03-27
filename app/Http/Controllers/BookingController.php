<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterAppointmentRequest;
use Carbon\Carbon;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Service;

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
            $business->id,
            $appointment->id
        ));

        $this->concierge->business($business);

        $appointmentManager = $this->concierge->booking()->appointment($appointment->hash);

        switch ($action) {
            case 'cancel':
                $appointment = $appointmentManager->cancel();
                break;
            case 'confirm':
                $appointment = $appointmentManager->confirm();
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
            'user' => auth()->user()
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

    //////////
    // AJAX //
    //////////

    /**
     * Get available times.
     *
     * @param int    $businessId
     * @param int    $serviceId
     * @param string $date
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTimes($businessId, $serviceId, $date)
    {
        logger()->info(__METHOD__);
        logger()->info("businessId:$businessId serviceId:$serviceId date:$date");

        $business = Business::findOrFail($businessId);
        $service = Service::findOrFail($serviceId);

        $vacancies = $business->vacancies()->forService($serviceId)->forDate(Carbon::parse($date))->get();

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
            $beginTime = $vacancy->start_at->copy();

            $step = $this->calculateStep($vacancy->business, $service->duration);

            for ($i = 0; $i <= 24; $i++) {
                $endTime = $beginTime->copy()->addMinutes($step);
                $serviceEndTime = $beginTime->copy()->addMinutes($service->duration);
                if ($vacancy->hasRoomBetween($beginTime, $serviceEndTime)) {
                    $times[] = $beginTime->timezone($vacancy->business->timezone)->toTimeString();
                }
                $beginTime->addMinutes($step);
            }
        }

        return $times;
    }

    protected function calculateStep(Business $business, $defaultStep = 30)
    {
        $step = $business->pref('timeslot_step');

        if (0 != $step) {
            return $step;
        }

        return $defaultStep;
    }
}
