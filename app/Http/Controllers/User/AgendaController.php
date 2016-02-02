<?php

namespace App\Http\Controllers\User;

use App\Events\NewAppointmentWasBooked;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Service;
use Timegridio\Concierge\Alfred as Concierge;
use Carbon;
use Event;
use Illuminate\Http\Request;
use Notifynder;

class AgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Alfred
     */
    private $concierge;

    /**
     * Create Controller.
     *
     * @param Timegridio\Concierge\Alfred $concierge
     */
    public function __construct(Concierge $concierge)
    {
        $this->concierge = $concierge;
        parent::__construct();
    }

    /**
     * List all pending appointments.
     *
     * @return Response Rendered list view for User Appointments
     */
    public function getIndex()
    {
        logger()->info(__METHOD__);

        $appointments = $this->concierge->getUnarchivedAppointments(auth()->user()->appointments());

        return view('user.appointments.index', compact('appointments'));
    }

    /**
     * get Availability for Business.
     *
     * @param Business $business Business to query
     *
     * @return Response Rendered view of Appointment booking form
     */
    public function getAvailability(Business $business, Request $request)
    {
        logger()->info(__METHOD__);

        $date = $request->input('date', 'today');
        $days = $request->input('days', 7);

        // BEGIN

        Notifynder::category('user.checkingVacancies')
           ->from('App\Models\User', auth()->user()->id)
           ->to('Timegridio\Concierge\Models\Business', $business->id)
           ->url('http://localhost')
           ->send();

        if (!auth()->user()->getContactSubscribedTo($business)) {
            logger()->info('  [ADVICE] User not subscribed to Business');

            flash()->warning(trans('user.booking.msg.you_are_not_subscribed_to_business'));

            return redirect()->route('user.businesses.home', compact('business'));
        }

        $startFromDate = $this->sanitizeDate($date);

        if ($startFromDate->isPast()) {
            $startFromDate = $this->sanitizeDate('today');
        }

        $includeToday = $business->pref('appointment_take_today');

        if ($startFromDate->isToday() && !$includeToday) {
            $startFromDate = $this->sanitizeDate('tomorrow');
        }

        $this->concierge->setBusiness($business);

        $availability = $this->concierge->getVacancies(auth()->user(), $startFromDate->toDateString(), $days);

        return view(
            'user.appointments.'.$business->strategy.'.book',
            compact('business', 'availability', 'startFromDate')
        );
    }

    /**
     * post Store.
     *
     * @param Request $request Input data of booking form
     *
     * @return Response Redirect to Appointments listing
     */
    public function postStore(Request $request)
    {
        logger()->info(__METHOD__);

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $issuer = auth()->user();

        $business = Business::findOrFail($request->input('businessId'));
        $contact = $issuer->getContactSubscribedTo($business->id);
        $service = Service::find($request->input('service_id'));

        $strTime = $request->input('_time') ?: $business->pref('start_at');
        $strDateTime = $request->input('_date').' '.$strTime.' '.$business->timezone;
        $datetime = Carbon::parse($strDateTime)->setTimezone('UTC');

        $comments = $request->input('comments');

        $this->concierge->setBusiness($business);

        logger()->info('issuer:'.$issuer->id);
        logger()->info('business:'.$business->id);
        logger()->info('contact:'.$contact->id);
        logger()->info('service:'.$service->id);
        logger()->info('datetime:'.$datetime);

        $appointment = $this->concierge->makeReservation($issuer, $business, $contact, $service, $datetime, $comments);

        if (false === $appointment) {
            logger()->info('[ADVICE] Unable to book');

            flash()->warning(trans('user.booking.msg.store.error'));

            return redirect()->back();
        }

        if (!$appointment->exists) {
            logger()->info('[ADVICE] Appointment is duplicated');

            flash()->warning(trans('user.booking.msg.store.sorry_duplicated', ['code' => $appointment->code]));

            return redirect()->route('user.agenda');
        }

        logger()->info('Appointment saved successfully');

        event(new NewAppointmentWasBooked($issuer, $appointment));

        flash()->success(trans('user.booking.msg.store.success', ['code' => $appointment->code]));

        return redirect()->route('user.agenda', '#'.$appointment->code);
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * Sanitize Date String.
     *
     * @param string $dateString
     *
     * @return Carbon\Carbon
     */
    protected function sanitizeDate($dateString)
    {
        try {
            $date = Carbon::parse($dateString);
        } catch (\Exception $e) {
            logger()->warning('Unexpected date string: '.$dateString);
            $date = Carbon::now();
        }

        return $date;
    }
}
