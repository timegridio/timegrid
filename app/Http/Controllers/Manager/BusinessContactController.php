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


class BusinessContactController extends Controller {
#
#	protected $business = null;
#
#	public function __construct()
#	{
#		$this->business = Business::findOrFail( Session::get('selected.business_id') );
#	}
#
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
	public function create(Business $business, ContactFormRequest $request)
	{
		return view('manager.contacts.create', compact('headerlang', 'business'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Business $business, ContactFormRequest $request)
	{
		# $business = Business::findOrFail( Session::get('selected.business_id') );
		$existing_contacts = Contact::where(['nin' => $request->input('nin')])->get();

		foreach ($existing_contacts as $existing_contact) {
			if ($existing_contact->isSuscribedTo($business)) {
				Flash::warning(trans('manager.contacts.msg.store.warning_showing_existing_contact'));
				return Redirect::route('manager.business.contact.show', [$business, $existing_contact]);
			}
		}

		$contact = Contact::create( Request::all() );
		$business->contacts()->attach($contact);
		$business->save();

		Flash::success(trans('manager.contacts.msg.store.success'));
		return Redirect::route('manager.business.contact.show', [$business, $contact]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Business $business, Contact $contact, ContactFormRequest $request)
	{
		# $business = $this->business;
		return view('manager.contacts.show', compact('business', 'contact'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Business $business, Contact $contact, ContactFormRequest $request)
	{
		return view('manager.contacts.edit', compact('business', 'contact'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Business $business, Contact $contact, ContactFormRequest $request)
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
		return Redirect::route('manager.business.contact.show', [$business, $contact]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Business $business, Contact $contact, ContactFormRequest $request)
	{
		$contact->delete();

		Flash::success( trans('manager.contacts.msg.destroy.success') );
		return Redirect::route('manager.business.show', $business);
	}
}
