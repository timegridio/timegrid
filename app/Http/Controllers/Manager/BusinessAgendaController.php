<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\TG\Business\Token as BusinessToken;
use JavaScript;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;

class BusinessAgendaController extends Controller
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
        $this->concierge = $concierge;

        parent::__construct();
    }

    /**
     * get Index.
     *
     * @param Business $business Business to get agenda
     *
     * @return Response Rendered view of Business agenda
     */
    public function getIndex(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);

        $appointments = $this->concierge->business($business)->getUnarchivedAppointments();

        $viewKey = count($appointments) == 0
            ? 'manager.businesses.appointments.empty'
            : "manager.businesses.appointments.{$business->strategy}.index";

        $user = auth()->user();

        return view($viewKey, compact('business', 'appointments', 'user'));
    }

    public function getCalendar(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);

        $appointments = $this->concierge->business($business)->getActiveAppointments();

        $jsAppointments = [];

        foreach ($appointments as $appointment) {
            $jsAppointments[] = [
                'title' => $appointment->contact->firstname.' / '.$appointment->service->name,
                'color' => $appointment->service->color,
                'start' => $appointment->start_at->timezone($business->timezone)->toIso8601String(),
                'end'   => $appointment->finish_at->timezone($business->timezone)->toIso8601String(),
                ];
        }

        $slotDuration = count($appointments) > 5 ? '0:15' : '0:30';

        $icalURL = $this->generateICalURL($business);

        unset($appointments);

        JavaScript::put([
            'minTime'      => $business->pref('start_at'),
            'maxTime'      => $business->pref('finish_at'),
            'events'       => $jsAppointments,
            'lang'         => $this->getActiveLanguage($business->locale),
            'slotDuration' => $slotDuration,
        ]);

        return view('manager.businesses.appointments.calendar', compact('business', 'icalURL'));
    }

    protected function getActiveLanguage($locale)
    {
        return session()->get('language', substr($locale, 0, 2));
    }

    protected function generateICalURL(Business $business)
    {
        $businessToken = new BusinessToken($business);

        return route('business.ical.download', [$business, $businessToken->generate()]);
    }
}
