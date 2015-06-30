<?php namespace App\Http\Controllers\Manager;

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
		return view('manager.contacts.create', compact('headerlang'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ContactFormRequest $request)
	{
		$business = Business::findOrFail( Session::get('selected.business_id') );
		$existing_contacts = Contact::where(['nin' => $request->input('nin')])->get();

		foreach ($existing_contacts as $existing_contact) {
			if ($existing_contact->isSuscribedTo($business)) {
				Flash::warning(trans('manager.contacts.msg.store.warning_showing_existing_contact'));
				return Redirect::route('manager.contact.show', $existing_contact->id)->with('message', trans('manager.contacts.msg.store.warning_showing_existing_contact'));
			}
		}

		$contact = Contact::create( Request::all() );
		$business->contacts()->attach($contact);
		$business->save();

		Flash::success(trans('manager.contacts.msg.store.success'));
		return Redirect::route('manager.contact.show', $contact->id)->with('message', trans('manager.contacts.msg.store.success'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Contact $contact, ContactFormRequest $request)
	{
		return view('manager.contacts.show', compact('contact'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Contact $contact, ContactFormRequest $request)
	{
		return view('manager.contacts.edit', compact('contact'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Contact $contact, ContactFormRequest $request)
	{
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
		return Redirect::route('manager.contact.show', $contact->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Contact $contact, ContactFormRequest $request)
	{
		$contact->delete();

		Flash::success( trans('manager.contacts.msg.destroy.success') );
		return Redirect::route('manager.business.show', Session::get('selected.business_id'));
	}
}
