<?php

namespace App\Http\Controllers\User;

use Event;
use Flash;
use Carbon;
use Notifynder;
use App\Http\Requests;
use App\Models\Service;
use App\Models\Business;
use App\Events\NewBooking;
use Illuminate\Http\Request;
use App\ConciergeServiceLayer;
use App\Http\Controllers\Controller;

/**
 * ToDo:
 *     - Use constructor dependency injection for Auth, Flash, Event
 *     - Use constructor dependency injection for ConciergeServiceLayer
 */
class AgendaController extends Controller
{
    /**
     * get Index
     *
     * @return Response Rendered list view for User Appointments
     */
    public function getIndex(ConciergeServiceLayer $concierge)
    {
        $this->log->info('AgendaController: getIndex');
        $appointments = $concierge->getAppointmentsFor(auth()->user());
        return view('user.appointments.index', compact('appointments'));
    }

    /**
     * get Availability for Business
     *
     * @param  Business              $business  Business to query
     * @param  ConciergeServiceLayer $concierge Concierge injection
     * @return Response Rendered view of Appointment booking form
     */
    public function getAvailability(Business $business, ConciergeServiceLayer $concierge)
    {
        $this->log->info('AgendaController: getBook');

        Notifynder::category('user.checkingVacancies')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->send();

        if (!auth()->user()->getContactSubscribedTo($business)) {
            $this->log->info('AgendaController: getIndex: [ADVICE] User not subscribed to Business');
            Flash::warning(trans('user.booking.msg.you_are_not_subscribed_to_business'));
            return redirect()->back();
        }

        $availability = $concierge->getVacancies($business, auth()->user(), 7);
        return view('user.appointments.'.$business->strategy.'.book', compact('business', 'availability'));
    }

    /**
     * post Store
     *
     * @param  Request $request Input data of booking form
     * @param  ConciergeServiceLayer $concierge Concierge injection
     * @return Response         Redirect to Appointments listing
     */
    public function postStore(Request $request, ConciergeServiceLayer $concierge)
    {
        $this->log->info('AgendaController: postStore');
        $issuer = auth()->user();

        $business = Business::findOrFail($request->input('businessId'));
        $contact = $issuer->getContactSubscribedTo($business);
        $service = Service::find($request->input('service_id'));
        $datetime = Carbon::parse($request->input('_date').' '.$business->pref('start_at'))->timezone($business->timezone);
        $comments = $request->input('comments');

        $appointment = $concierge->makeReservation($issuer, $business, $contact, $service, $datetime, $comments);

        if (false === $appointment) {
            $this->log->info('AgendaController: postStore: [ADVICE] Unable to book ');
            Flash::warning(trans('user.booking.msg.store.error'));
            return redirect()->route('user.booking.list');
        }

        $appointmentPresenter = $appointment->getPresenter();
        if ($appointment->exists) {
            $this->log->info('AgendaController: postStore: Appointment saved successfully ');
            Event::fire(new NewBooking($issuer, $appointment));
            Flash::success(trans('user.booking.msg.store.success', ['code' => $appointmentPresenter->code()]));
        } else {
            $this->log->info('AgendaController: postStore: [ADVICE] Appointment is duplicated ');
            Flash::warning(trans('user.booking.msg.store.sorry_duplicated', ['code' => $appointmentPresenter->code()]));
        }
        return redirect()->route('user.booking.list');
    }
}
