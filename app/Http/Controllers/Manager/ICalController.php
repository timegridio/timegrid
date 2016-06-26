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
        $appointments = $business->bookings;

        $events = [];

        foreach ($appointments as $appointment) {
            $vEvent = new Event();

            $startAt = new \DateTime($appointment->start_at->timezone($business->timezone)->toDateTimeString(), new \DateTimeZone($business->timezone));
            $endAt = new \DateTime($appointment->finish_at->timezone($business->timezone)->toDateTimeString(), new \DateTimeZone($business->timezone));

            $vEvent->setDtStart($startAt);
            $vEvent->setDtEnd($endAt);
            $vEvent->setSummary($appointment->contact->firstname.'/'.$appointment->service->name.'@'.$business->slug);

            $vEvent->setUseTimezone(true);

            $events[] = $vEvent;
        }

        return $events;
    }
}
