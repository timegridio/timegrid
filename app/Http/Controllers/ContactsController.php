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
		
		$existing_contact = \App\Contact::where(['nin' => $request->input('nin')])->first();

		if ($existing_contact !== null) {

			Flash::warning(trans('manager.contacts.msg.store.warning_showing_existing_contact'));

			return Redirect::route('manager.contacts.show', $existing_contact->first()->id)->with('message', trans('manager.contacts.msg.store.warning_showing_existing_contact'));
		}

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
	public function edit($id, ContactFormRequest $request)
	{
        $contact = Contact::findOrFail($id);

        return view('manager.contacts.edit', compact('contact'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ContactFormRequest $request)
	{
        $user = \Auth::user();

        $contact = Contact::findOrFail($id);

        $contact->update([
            'firstname'       => $request->get('firstname'),
            'lastname'        => $request->get('lastname'), 
            'email'           => $request->get('email'), 
            'nin'             => $request->get('nin'), 
            'gender'          => $request->get('gender'), 
            'birthdate'       => $request->get('birthdate'), 
            'mobile'          => $request->get('mobile'), 
            'mobile_country'  => $request->get('mobile_country'), 
            'notes'           => $request->get('notes')
        ]);

        Flash::success( trans('manager.contacts.msg.update.success') );

        return \Redirect::route('manager.contacts.show', array($contact->id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, ContactFormRequest $request)
	{
        $contact = Contact::findOrFail($id);

        $contact->delete();

        $selectd_business_id = Session::get('selected.business_id');

        Flash::success( trans('manager.contacts.msg.destroy.success') );

        return \Redirect::route('manager.businesses.show', $selectd_business_id);
	}

}
