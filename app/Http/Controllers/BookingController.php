<?php

namespace App\Http\Controllers;

use App\Events\AppointmentWasCanceled;
use App\Events\AppointmentWasConfirmed;
use App\Http\Requests\AlterAppointmentRequest;
use Carbon\Carbon;
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
        logger()->info(__CLASS__.':'.__METHOD__);

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
    public function getDates($businessId, $serviceId)
    {
        logger()->info(__CLASS__.':'.__METHOD__);
        logger()->info(serialize(compact('businessId', 'serviceId')));

        $business = Business::findOrFail($businessId);
        $service = $business->services()->findOrFail($serviceId);

        $days = $business->pref('availability_future_days');
        $startFrom = $business->pref('appointment_take_today') ? 'today' : 'tomorrow';

        $baseDate = Carbon::parse($startFrom);

        $vacancies = $business->vacancies()->forService($serviceId)->get();

        $dates = array_pluck($vacancies->toArray(), 'date');

        return response()->json([
            'business' => $businessId,
            'service'  => [
                'id'       => $service->id,
                'duration' => $service->duration,
            ],
            'dates'     => $dates,
            'startDate' => $baseDate->toDateString(),
            'endDate'   => $baseDate->addDays($days)->toDateString(),
        ], 200);
    }

    /**
     * Get available times.
     *
     * @param int    $businessId
     * @param int    $serviceId
     * @param string $date
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTimes($businessId, $serviceId, $date, $timezone = false)
    {
        logger()->info(__CLASS__.':'.__METHOD__);
        logger()->info(serialize(compact('businessId', 'serviceId', 'date', 'timezone')));

        $business = Business::findOrFail($businessId);
        $service = $business->services()->findOrFail($serviceId);

        $vacancies = $business->vacancies()->forService($serviceId)->forDate(Carbon::parse($date))->get();

        if ($timezone == false) {
            $timezone = auth()->guest() ? $business->timezone : auth()->user()->pref('timezone');
        }

        logger()->info("Using Timezone: {$timezone}");

        $times = $this->splitTimes($vacancies, $service, $timezone);

        return response()->json([
            'business' => $businessId,
            'service'  => [
                'id'       => $service->id,
                'duration' => $service->duration,
            ],
            'date'     => $date,
            'times'    => $times,
            'timezone' => $timezone,
        ], 200);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function splitTimes($vacancies, $service, $timezone = false, $timeformat = 'H:i')
    {
        $times = [];
        foreach ($vacancies as $vacancy) {
            $selectedTimezone = $timezone ?: $vacancy->business->timezone;

            logger()->info("Using Timezone: {$selectedTimezone}");

            $beginTime = $vacancy->start_at->copy();

            $step = $this->calculateStep($vacancy->business, $service->duration);

            $maxNumberOfSlots = round($vacancy->finish_at->diffInMinutes($beginTime) / $step);

            for ($i = 0; $i <= $maxNumberOfSlots; $i++) {
                $serviceEndTime = $beginTime->copy()->addMinutes($service->duration);
                if ($vacancy->hasRoomBetween($beginTime, $serviceEndTime)) {
                    $times[] = $beginTime->timezone($selectedTimezone)->format($timeformat);
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
