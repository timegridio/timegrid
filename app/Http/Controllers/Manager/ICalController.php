<?php

namespace App\Http\Controllers\Manager;

use App\BusinessToken;
use App\Http\Controllers\Controller;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Timegridio\Concierge\Models\Business;

class ICalController extends Controller
{
    public function download(Business $business, $token)
    {
        logger()->info(__CLASS__.':'.__METHOD__);

        $businessToken = new BusinessToken($business);

        if ($businessToken->generate() !== $token) {
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
}
