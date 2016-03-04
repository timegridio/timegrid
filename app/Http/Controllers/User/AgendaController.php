<?php

namespace App\Http\Controllers\User;

use App\Events\NewAppointmentWasBooked;
use App\Http\Controllers\Controller;
use Carbon;
use Event;
use Illuminate\Http\Request;
use Notifynder;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Exceptions\DuplicatedAppointmentException;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Service;
use Timegridio\Concierge\Vacancy\VacancyManager;

class AgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $concierge;

    /**
     * Create Controller.
     *
     * @param Timegridio\Concierge\Concierge
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

        $appointments = auth()->user()->appointments()->orderBy('start_at')->unarchived()->get();

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

        if (!auth()->user()->getContactSubscribedTo($business)) {
            logger()->info('  [ADVICE] User not subscribed to Business');

            flash()->warning(trans('user.booking.msg.you_are_not_subscribed_to_business'));

            return redirect()->route('user.businesses.home', compact('business'));
        }

        // BEGIN

        Notifynder::category('user.checkingVacancies')
           ->from('App\Models\User', auth()->user()->id)
           ->to('Timegridio\Concierge\Models\Business', $business->id)
           ->url('http://localhost')
           ->send();

        $date = $request->input('date', 'today');
        $days = $request->input('days', $business->pref('availability_future_days'));

        $startFromDate = $this->sanitizeDate($date);

        if ($startFromDate->isPast()) {
            $startFromDate = $this->sanitizeDate('today');
        }

        $includeToday = $business->pref('appointment_take_today');

        if ($startFromDate->isToday() && !$includeToday) {
            $startFromDate = $this->sanitizeDate('tomorrow');
        }

        $availability = $this->concierge
                             ->business($business)
                             ->vacancies()
                             ->generateAvailability($business->vacancies, $startFromDate->toDateString(), $days);

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

#        $strTime = $request->input('_time') ?: $business->pref('start_at');
#        $strDateTime = $request->input('_date').' '.$strTime.' '.$business->timezone;
#        $datetime = Carbon::parse($strDateTime)->setTimezone('UTC');

        $date = Carbon::parse($request->input('_date'))->toDateString();
        $time = Carbon::parse($request->input('_time'))->toTimeString();

        $comments = $request->input('comments');

        $reservation = [
            'issuer'   => $issuer->id,
            'contact'  => $contact,
            'service'  => $service,
            'date'     => $date,
            'time'     => $time,
            'timezone' => $business->timezone,
            'comments' => $comments,
        ];

        logger()->info('issuer:'.$issuer->id);
        logger()->info('business:'.$business->id);
        logger()->info('contact:'.$contact->id);
        logger()->info('service:'.$service->id);
        logger()->info('date:'.$date);
        logger()->info('time:'.$time);
        logger()->info('timezone:'.$business->timezone);

        try {
            $appointment = $this->concierge->business($business)->takeReservation($reservation);

        } catch (DuplicatedAppointmentException $e) {
            $code = $this->concierge->appointment()->code;

            logger()->info('DUPLICATED Appointment with CODE:'.$code);

            flash()->warning(trans('user.booking.msg.store.sorry_duplicated', ['code' => $code]));

            return redirect()->route('user.agenda');
        }

        if (false === $appointment) {
            logger()->info('[ADVICE] Unable to book');

            flash()->warning(trans('user.booking.msg.store.error'));

            return redirect()->back();
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
