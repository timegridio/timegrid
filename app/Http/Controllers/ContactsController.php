<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use App\Business;
use App\Contact;
use Illuminate\Support\Facades\Redirect;
use Flash;
use Session;
use Request;


class ContactsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(ContactFormRequest $request)
	{
		return view('manager.contacts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ContactFormRequest $request)
	{
		//
		$contact = \App\Contact::create( Request::all() );

		$business_id = Session::get('selected.business_id');

		$business = \App\Business::findOrFail($business_id);

		$business->contacts()->attach($contact);

		$business->save();

		Flash::success(trans('manager.contacts.msg.store.success'));

		return Redirect::route('manager.contacts.show', $contact->id)->with('message', trans('manager.contacts.msg.store.success'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$contact = Contact::findOrFail($id);

		return view('manager.contacts.show', compact('contact'));
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
