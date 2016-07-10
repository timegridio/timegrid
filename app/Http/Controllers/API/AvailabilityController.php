<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Availability\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;

class AvailabilityController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $availability;

    /**
     * Create controller.
     *
     * @param Timegridio\Concierge\Concierge
     */
    public function __construct(AvailabilityService $availability)
    {
        parent::__construct();

        $this->availability = $availability;
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
        logger()->info(__METHOD__);
        logger()->info(serialize(compact('businessId', 'serviceId')));

        $business = Business::findOrFail($businessId);
        $service = $business->services()->findOrFail($serviceId);

        $days = $business->pref('availability_future_days');
        $startFrom = $business->pref('appointment_take_today') ? 'today' : 'tomorrow';

        $baseDate = Carbon::parse($startFrom);
        $endDate = $baseDate->copy()->addDays($days);

        // $this->availability->excludeDates(['humanresource-slug:YYYY-MM-DD']);

        $this->excludeDates($businessId);

        $dates = $this->availability->getDates($business, $service->id);

        $disabledDates = $this->getDisabledDates($baseDate, $endDate, $dates);

        logger()->debug('Disabled Dates:'.serialize($disabledDates));

        return response()->json([
            'business' => $business->id,
            'service'  => [
                'id'       => $service->id,
                'duration' => $service->duration,
            ],
            'dates'         => $dates,
            'disabledDates' => $disabledDates,
            'startDate'     => $baseDate->toDateString(),
            'endDate'       => $endDate->toDateString(),
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
        logger()->info(__METHOD__);
        logger()->info(serialize(compact('businessId', 'serviceId', 'date', 'timezone')));

        $business = Business::findOrFail($businessId);
        $service = $business->services()->findOrFail($serviceId);

        $timezone = $this->decideTimezone($timezone, $business->timezone);

        logger()->info("Using Timezone: {$timezone}");

        $times = $this->availability->timezone($timezone)->getTimes($business, $service, Carbon::parse($date));

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

    protected function decideTimezone($preferredTimezone, $fallbackTimezone)
    {
        if ($preferredTimezone == false) {
            $timezone = auth()->guest() ? $fallbackTimezone : auth()->user()->pref('timezone');
        }

        return $timezone ?: $fallbackTimezone;
    }

    protected function getDisabledDates(Carbon $start, Carbon $end, array $enabledDates)
    {
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($start, $interval, $end->addDay());

        $dates = [];
        foreach ($daterange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return array_values(array_diff($dates, $enabledDates));
    }

    protected function excludeDates($businessId)
    {
        $filepath = "business/{$businessId}/ical/ical-exclusion.compiled";
        if (!Storage::exists($filepath)) {
            // logger()->debug('No ical-exclude.compiled file found:'.$filepath);
            return;
        }

        $excluded = Storage::get($filepath);

        logger()->debug('ICal Exclude Dates:'.serialize($excluded));

        $this->availability->excludeDates(explode("\n", $excluded));
    }
}
