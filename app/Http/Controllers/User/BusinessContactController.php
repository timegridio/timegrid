<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterContactRequest;
use App\Http\Requests\ViewContactRequest;
use App\Business;
use App\Contact;
use Illuminate\Support\Facades\Redirect;
use Flash;
use Session;
use Request;

class BusinessContactController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Business $business, AlterContactRequest $request)
    {
        $existing_contact = Contact::where(['email' => \Auth::user()->email])->get()->first();

        if ($existing_contact !== null && !$existing_contact->isSuscribedTo($business)) {
            $business->contacts()->attach($existing_contact);
            $business->save();
            Flash::success(trans('user.contacts.msg.store.associated_existing_contact'));
            return Redirect::route('user.business.contact.show', [$business, $existing_contact]);
        }

        return view('user.contacts.create', compact('headerlang', 'business'));
    }

    public function store(Business $business, AlterContactRequest $request)
    {
        $existing_contacts = Contact::where(['email' => $request->input('email')])->get();

        foreach ($existing_contacts as $existing_contact) {
            if ($existing_contact->isSuscribedTo($business)) {
                \Auth::user()->contacts()->save($existing_contact);

                Flash::warning(trans('user.contacts.msg.store.warning.already_registered'));
                return Redirect::route('user.business.contact.show', [$business, $existing_contact]);
            }
            $business->contacts()->attach($existing_contact);
            $business->save();            
            Flash::warning(trans('user.contacts.msg.store.warning.showing_existing_contact'));
            return Redirect::route('user.business.contact.show', [$business, $existing_contact]);
        }

        $contact = Contact::create(Request::all());
        $business->contacts()->attach($contact);
        $business->save();

        Flash::success(trans('user.contacts.msg.store.success'));
        return Redirect::route('user.business.contact.show', [$business, $contact]);
    }

    public function show(Business $business, Contact $contact, ViewContactRequest $request)
    {
        return view('user.contacts.show', compact('business', 'contact'));
    }

    public function edit(Business $business, Contact $contact, AlterContactRequest $request)
    {
        return view('user.contacts.edit', compact('business', 'contact'));
    }

    public function update(Business $business, Contact $contact, AlterContactRequest $request)
    {
        $contact->update([
            'mobile'          => $request->get('mobile'),
            'mobile_country'  => $request->get('mobile_country')
        ]);

        Flash::success(trans('user.contacts.msg.update.success'));
        return Redirect::route('user.business.contact.show', [$business, $contact]);
    }
/*
    public function destroy(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $contact->delete();

        Flash::success( trans('manager.contacts.msg.destroy.success') );
        return Redirect::route('manager.business.show', $business);
    }
*/
}
