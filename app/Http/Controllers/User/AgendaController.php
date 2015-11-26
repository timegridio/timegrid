<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Events\NewBooking;
use App\ConciergeServiceLayer;
use App\Business;
use App\Service;
use Notifynder;
use Carbon;
use Flash;
use Event;
use Log;

class AgendaController extends Controller
{
    /**
     * get Index
     *
     * @return Response Rendered list view for User Appointments
     */
    public function getIndex(ConciergeServiceLayer $concierge)
    {
        Log::info('AgendaController: getIndex');
        $appointments = $concierge->getAppointmentsFor(\Auth::user());
        return view('user.appointments.index', compact('appointments'));
    }

    /**
     * get Availability
     *
     * @return Response Rendered view of Appointment booking form
     */
    public function getAvailability(Business $business, ConciergeServiceLayer $concierge)
    {
        Log::info('AgendaController: getBook');

        Notifynder::category('user.checkingVacancies')
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $business->id)
                   ->url('http://localhost')
                   ->send();

        if (!\Auth::user()->getContactSuscribedTo($business)) {
            Log::info('AgendaController: getIndex: [ADVICE] User not suscribed to Business');
            Flash::warning(trans('user.booking.msg.you_are_not_suscribed_to_business'));
            return Redirect::back();
        }

        $availability = $concierge->getVacancies($business, \Auth::user(), 7);
        return view('user.appointments.'.$business->strategy.'.book', compact('business', 'availability'));
    }

    /**
     * post Store
     *
     * @param  Request $request Input data of booking form
     * @return Response         Redirect to Appointments listing
     */
    public function postStore(Request $request, ConciergeServiceLayer $concierge)
    {
        Log::info('AgendaController: postStore');
        $issuer = \Auth::user();

        $business = Business::findOrFail($request->input('businessId'));
        $contact = $issuer->getContactSuscribedTo($business);
        $service = Service::find($request->input('service_id'));
        $datetime = Carbon::parse($request->input('_date').' '.$business->pref('start_at'));
        $comments = $request->input('comments');

        $appointment = $concierge->makeReservation($issuer, $business, $contact, $service, $datetime, $comments);

        if (false === $appointment) {
            Log::info('AgendaController: postStore: [ADVICE] Unable to book ');
            Flash::warning(trans('user.booking.msg.store.error'));
            return Redirect::route('user.booking.list');
        }

        $appointmentPresenter = $appointment->getPresenter();
        if ($appointment->exists) {
            Log::info('AgendaController: postStore: Appointment saved successfully ');
            Event::fire(new NewBooking($issuer, $appointment));
            Flash::success(trans('user.booking.msg.store.success', ['code' => $appointmentPresenter->code()]));
        } else {
            Log::info('AgendaController: postStore: [ADVICE] Appointment is duplicated ');
            Flash::warning(trans('user.booking.msg.store.sorry_duplicated', ['code' => $appointmentPresenter->code()]));
        }
        return Redirect::route('user.booking.list');
    }

    /**
     * TODO: Business is not actually needed as Strategy can be retrieved from
     *       Appointment relationship.
     *
     * get Show
     *
     * @param  Business    $business    Business of the desired Appointment
     * @param  Appointment $appointment Appointment to show
     * @return Response                 Rendered view for desired Appointment
     */
    public function getShow(Business $business, Appointment $appointment)
    {
        Log::info("AgendaController: getShow: businessId:{$business->id} appointmentId:{$appointment->id}");
        return view('user.appointments.'.$business->strategy.'.show', compact('appointment'));
    }
}
