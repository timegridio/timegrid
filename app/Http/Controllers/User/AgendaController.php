<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Flash;
use App\Appointment;
use App\Business;
use App\BookingStrategy;
use App\ConciergeStrategy as Concierge;
use Notifynder;
use Carbon;
use Session;
use Event;
use App\Events\NewBooking;

class BookingController extends Controller
{
    public function getIndex()
    {
        $appointments = \Auth::user()->appointments()->orderBy('start_at')->get();
        return view('user.appointments.index', compact('appointments'));
    }

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

    public function getShow(Business $business, Appointment $appointment)
    {
        return view('user.appointments.'.$business->strategy.'.show', compact('appointment'));
    }
}
