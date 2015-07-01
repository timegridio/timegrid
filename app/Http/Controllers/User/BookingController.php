<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Flash;
use App\Appointment;
use Session;
use URL;

class BookingController extends Controller {

	public function getIndex()
	{
		$appointments = \Auth::user()->appointments;
		return view('user.appointments.index', compact('appointments'));
	}

	public function getBook()
	{
		$business = \App\Business::findOrFail(Session::get('selected.business_id'));
		if (!\Auth::user()->suscribedTo($business)) {
			Flash::warning(trans('user.booking.msg.you_are_not_suscribed_to_business'));
			return Redirect::back();
		}
		return view('user.appointments.book');
	}

	public function postStore(Request $request)
	{
		if (!\Auth::user()->contacts) {
			Flash::error(trans('user.booking.msg.you_are_not_suscribed_to_business'));
			return Redirect::back();
		}

		$data = $request->all();
		$business = \App\Business::findOrFail(Session::get('selected.business_id'));
		$data['start_at'] = $request->input('_date').' '.$request->input('_time');
		$data['business_id'] = $business->id;
		$data['contact_id'] = \Auth::user()->suscribedTo($business)->id;
		$appointment = new Appointment($data);
		$appointment->save();

		Flash::success(trans('user.booking.msg.store.success'));
		return Redirect::route('user.booking.list')->with('message', trans('user.booking.msg.store.success'));
	}

	public function getShow($id)
	{
		//
	}

	public function edit($id)
	{
		//
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

}
