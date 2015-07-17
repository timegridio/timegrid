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

class BusinessContactController extends Controller
{
    public function index(Business $business, ContactFormRequest $request)
    {
        return view('manager.contacts.index', compact('business'));
    }

    public function create(Business $business, ContactFormRequest $request)
    {
        return view('manager.contacts.create', compact('business'));
    }

    public function store(Business $business, ContactFormRequest $request)
    {
        if (trim($request->input('nin'))) {
            $existing_contacts = Contact::whereNotNull('nin')->where(['nin' => $request->input('nin')])->get();
            foreach ($existing_contacts as $existing_contact) {
                if ($existing_contact->isSuscribedTo($business)) {
                    Flash::warning(trans('manager.contacts.msg.store.warning_showing_existing_contact'));
                    return Redirect::route('manager.business.contact.show', [$business, $existing_contact]);
                }
            }
        }

        $contact = Contact::create($request->all());
        $business->contacts()->attach($contact, ['notes' => $request->only('notes')]);
        $business->save();

        Flash::success(trans('manager.contacts.msg.store.success'));
        return Redirect::route('manager.business.contact.show', [$business, $contact]);
    }

    public function show(Business $business, Contact $contact, ContactFormRequest $request)
    {
        # $business = $this->business;
        return view('manager.contacts.show', compact('business', 'contact'));
    }

    public function edit(Business $business, Contact $contact, ContactFormRequest $request)
    {
        return view('manager.contacts.edit', compact('business', 'contact'));
    }

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

        Flash::success(trans('manager.contacts.msg.update.success'));
        return Redirect::route('manager.business.contact.show', [$business, $contact]);
    }

    public function destroy(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $contact->businesses()->detach($business->id);

        Flash::success(trans('manager.contacts.msg.destroy.success'));
        return Redirect::route('manager.business.show', $business);
    }
}
