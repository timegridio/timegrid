<?php

namespace App\Http\Controllers\User;

use App\Events\NewBooking;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Service;
use App\Services\ConciergeService;
use Carbon;
use Event;
use Flash;
use Illuminate\Http\Request;
use Notifynder;

class AgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var App\Services\ConciergeService
     */
    private $concierge;

    /**
     * Create Controller.
     *
     * @param App\Services\ConciergeService $concierge
     */
    public function __construct(ConciergeService $concierge)
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
        $this->log->info(__METHOD__);

        $appointments = $this->concierge->getUnarchivedAppointmentsFor(auth()->user());

        return view('user.appointments.index', compact('appointments'));
    }

    /**
     * get Availability for Business.
     *
     * @param Business $business Business to query
     *
     * @return Response Rendered view of Appointment booking form
     */
    public function getAvailability(Business $business)
    {
        $this->log->info(__METHOD__);

        Notifynder::category('user.checkingVacancies')
           ->from('App\Models\User', auth()->user()->id)
           ->to('App\Models\Business', $business->id)
           ->url('http://localhost')
           ->send();

        if (!auth()->user()->getContactSubscribedTo($business)) {
            $this->log->info('  [ADVICE] User not subscribed to Business');

            Flash::warning(trans('user.booking.msg.you_are_not_subscribed_to_business'));

            return redirect()->back();
        }

        $includeToday = $business->pref('appointment_take_today');

        $this->concierge->setBusiness($business);

        $availability = $this->concierge->getVacancies(auth()->user(), 'today', 7);

        return view(
            'user.appointments.'.$business->strategy.'.book',
            compact('business', 'availability', 'includeToday')
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
        $this->log->info(__METHOD__);

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $issuer = auth()->user();

        $business = Business::findOrFail($request->input('businessId'));
        $contact = $issuer->getContactSubscribedTo($business->id);
        $service = Service::find($request->input('service_id'));

        $strDateTime = $request->input('_date').' '.$business->pref('start_at');
        $datetime = Carbon::parse($strDateTime.' '.$business->timezone)->setTimezone('UTC');

        $comments = $request->input('comments');

        $this->concierge->setBusiness($business);

        $appointment = $this->concierge->makeReservation($issuer, $business, $contact, $service, $datetime, $comments);

        if (false === $appointment) {
            $this->log->info('[ADVICE] Unable to book');

            Flash::warning(trans('user.booking.msg.store.error'));

            return redirect()->route('user.agenda');
        }

        if (!$appointment->exists) {
            $this->log->info('[ADVICE] Appointment is duplicated');

            Flash::warning(trans('user.booking.msg.store.sorry_duplicated', ['code' => $appointment->code]));

            return redirect()->route('user.agenda');
        }

        $this->log->info('Appointment saved successfully');

        event(new NewBooking($issuer, $appointment));

        Flash::success(trans('user.booking.msg.store.success', ['code' => $appointment->code]));

        return redirect()->route('user.agenda');
    }
}
