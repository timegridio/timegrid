<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Events\NewBooking;
use App\ConciergeStrategy as Concierge;
use App\BookingStrategy;
use App\Appointment;
use App\Business;
use Notifynder;
use Session;
use Carbon;
use Flash;
use Event;

class AgendaController extends Controller
{
    /**
     * get Index
     *
     * @return Response Rendered list view for User Appointments
     */
    public function getIndex()
    {
        $appointments = \Auth::user()->appointments()->orderBy('start_at')->get();
        return view('user.appointments.index', compact('appointments'));
    }

    /**
     * get Book
     *
     * @return Response Rendered view of Appointment booking form
     */
    public function getBook()
    {
        $business = Business::findOrFail(Session::get('selected.business')->id);

        Notifynder::category('user.checkingVacancies')
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $business->id)
                   ->url('http://localhost')
                   ->send();

        if (!\Auth::user()->suscribedTo($business)) {
            Flash::warning(trans('user.booking.msg.you_are_not_suscribed_to_business'));
            return Redirect::back();
        }

        $availability = Concierge::getVacancies($business, Carbon::now(), \Auth::user());
        return view('user.appointments.'.$business->strategy.'.book', compact('business', 'availability'));
    }

    /**
     * poset Store
     * 
     * @param  Request $request Input data of booking form
     * @return Response         Redirect to Appointments listing
     */
    public function postStore(Request $request)
    {
        $issuer = \Auth::user();
        $businessId = $request->input('businessId');

        // if (!$issuer->contacts) {
        //     Flash::error(trans('user.booking.msg.you_are_not_suscribed_to_business'));
        //     return Redirect::back();
        // }

        $data = $request->all();
        $business = Business::findOrFail($businessId);
        $data['start_at'] = $request->input('_date').' '.$request->input('_time');
        $data['contact_id'] = $issuer->suscribedTo($business)->id;
        $booking = new BookingStrategy($business->strategy);

        $appointment = $booking->makeReservation($issuer, $business, $data);
        if ($appointment->duplicates()) {
            Flash::warning(trans('user.booking.msg.store.sorry_duplicated', ['code' => $appointment->code]));
        } else {
            $appointment->save();
            Event::fire(new NewBooking($issuer, $appointment));
            Flash::success(trans('user.booking.msg.store.success', ['code' => $appointment->code]));
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
        return view('user.appointments.'.$business->strategy.'.show', compact('appointment'));
    }
}
