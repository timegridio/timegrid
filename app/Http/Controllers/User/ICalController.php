<?php

namespace App\Http\Controllers\User;

use App\TG\Business\Token as BusinessToken;
use App\Http\Controllers\Controller;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Timegridio\Concierge\Models\Business;
use Validator;

class ICalController extends Controller
{
    public function download(Business $business, $token)
    {
        logger()->info(__METHOD__);

        $validToken = with(new BusinessToken($business))->generate();

        $validator = Validator::make(compact('token'), [
            'token' => "bail|required|alpha_num|max:32|in:{$validToken}",
        ]);

        if ($validator->fails()) {
            abort(403);
        }

        // BEGIN
        $vCalendar = new Calendar($business->slug);

        $vCalendar->setPublishedTTL('PT1H');

        $events = $this->buildEvents($business);

        foreach ($events as $event) {
            $vCalendar->addComponent($event);
        }

        $type = 'text/calendar; charset=utf-8';
        $disposition = 'attachment; filename="calendar.ics"';

        $content = $vCalendar->render();

        return response($content)
                    ->header('Content-Type', $type)
                    ->header('Content-Disposition', $disposition);
    }

    protected function buildEvents(Business $business)
    {
        $businessAppointments = $business->bookings()->active()->get();

        $ownerAppointments = $business->owner()->appointments()->active()->get();

        $appointments = array_merge($businessAppointments->all(), $ownerAppointments->all());

        $events = [];

        foreach ($appointments as $appointment) {
            $vEvent = new Event();

            $startAt = new \DateTime($appointment->start_at->timezone($business->timezone)->toDateTimeString(), new \DateTimeZone($business->timezone));
            $endAt = new \DateTime($appointment->finish_at->timezone($business->timezone)->toDateTimeString(), new \DateTimeZone($business->timezone));

            $vEvent->setDtStart($startAt);
            $vEvent->setDtEnd($endAt);

            $vEvent->setStatus($this->mapStatus($appointment->status));

            $vEvent->setUniqueId($appointment->business->slug.':'.$appointment->code.'@timegrid.io');

            $summary = $appointment->contact->firstname.'/'.
                       $appointment->service->name.'@'.
                       $appointment->business->slug.
                       ' ['.$appointment->code.']';

            $vEvent->setSummary($summary);

            $vEvent->setDescription($appointment->comments);

            $vEvent->setUseTimezone(true);

            $events[] = $vEvent;
        }

        return $events;
    }

    /**
     * Map Timegridio\Concierge\Models\Appointment status into
     * Eluceo\iCal\Component\Event for ICal status compatibility
     */
    protected function mapStatus($status)
    {
        $mapping = [
            'R' => 'TENTATIVE',
            'C' => 'CONFIRMED',
            'A' => 'CANCELLED',
            'S' => 'CONFIRMED',
        ];

        return array_get($mapping, $status, 'TENTATIVE');
    }
}
