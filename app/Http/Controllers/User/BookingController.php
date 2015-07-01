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

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$appointments = \Auth::user()->appointments;
		return view('user.appointments.index', compact('appointments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getBook()
	{
		$business = \App\Business::findOrFail(Session::get('selected.business_id'));
		if (!\Auth::user()->suscribedTo($business)) {
			Flash::warning(trans('user.booking.msg.you_are_not_suscribed_to_business'));
			return Redirect::back();
		}
		return view('user.appointments.book');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
