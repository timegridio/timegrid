<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ContactFormRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Business;
use App\Contact;
use Request;
use Session;
use Flash;

class BusinessContactController extends Controller
{
    /**
     * index of Contacts for Business
     *
     * @param  Business           $business Business that holds the Contacts
     * @param  ContactFormRequest $request  Read access Request
     * @return Response                     Rendered view of Contact addressbook
     */
    public function index(Business $business, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: index: businessId:{$business->id}");

        return view('manager.contacts.index', compact('business'));
    }

    /**
     * create Contact
     *
     * @param  Business           $business Business that will hold the Contact
     * @param  ContactFormRequest $request  Contact form Request
     * @return Response                     Rendered form for Contact creation
     */
    public function create(Business $business, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: create: businessId:{$business->id}");
        return view('manager.contacts.create', compact('business'));
    }

    /**
     * store Contact
     *
     * @param  Business           $business Business that will hold the Contact
     * @param  ContactFormRequest $request  Contact form Request
     * @return Response                     Rendered view or Redirect
     */
    public function store(Business $business, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: store: businessId:{$business->id}");
        if (trim($request->input('nin'))) {
            $existing_contacts = Contact::whereNotNull('nin')->where(['nin' => $request->input('nin')])->get();
            foreach ($existing_contacts as $existing_contact) {
                $this->log->info("BusinessContactController: store: [ADVICE] Found existing contactId:{$existing_contact->id}");
                if ($existing_contact->isSuscribedTo($business)) {
                    $this->log->info("BusinessContactController: store: [ADVICE] Existing contactId:{$existing_contact->id} is already linked to businessId:{$business->id}");
                    Flash::warning(trans('manager.contacts.msg.store.warning_showing_existing_contact'));
                    return Redirect::route('manager.business.contact.show', [$business, $existing_contact]);
                }
            }
        }

        $contact = Contact::create($request->except('notes', '_token'));
        $business->contacts()->attach($contact);
        $business->save();
        $this->log->info("BusinessContactController: store: Contact created contactId:{$contact->id}");

        $contact->business($business)->pivot->update(['notes' => $request->get('notes')]);

        Flash::success(trans('manager.contacts.msg.store.success'));
        return Redirect::route('manager.business.contact.show', [$business, $contact]);
    }

    /**
     * show Contact
     *
     * @param  Business           $business Business holding the Contact
     * @param  Contact            $contact  Contact to show
     * @param  ContactFormRequest $request  Contact form Request
     * @return Response                     Rendered view of Contact show
     */
    public function show(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: show: businessId:{$business->id} contactId:{$contact->id}");
        return view('manager.contacts.show', compact('business', 'contact'));
    }

    /**
     * edit Contact
     *
     * @param  Business           $business Business holding the Contact
     * @param  Contact            $contact  Contact to edit
     * @param  ContactFormRequest $request  Contact Form Request
     * @return Response                     Rendered view of edit form
     */
    public function edit(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: edit: businessId:{$business->id} contactId:{$contact->id}");
        return view('manager.contacts.edit', compact('business', 'contact'));
    }

    /**
     * update Contact
     *
     * @param  Business           $business Business holding the Contact
     * @param  Contact            $contact  Contact to update
     * @param  ContactFormRequest $request  Contact form Request
     * @return Response                     Redirect to updated Contact show
     */
    public function update(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: update: businessId:{$business->id} contactId:{$contact->id}");
        $contact->update([
            'firstname'       => $request->get('firstname'),
            'lastname'        => $request->get('lastname'),
            'email'           => $request->get('email'),
            'nin'             => $request->get('nin'),
            'gender'          => $request->get('gender'),
            'birthdate'       => $request->get('birthdate'),
            'mobile'          => $request->get('mobile'),
            'mobile_country'  => $request->get('mobile_country'),
        ]);

        $contact->business($business)->pivot->update(['notes' => $request->get('notes')]);

        Flash::success(trans('manager.contacts.msg.update.success'));
        return Redirect::route('manager.business.contact.show', [$business, $contact]);
    }

    /**
     * TODO: Should probably redirect BACK
     *       Should probably perform a deletion
     *       Should probably be another method for unlinking
     *
     * destroy Contact
     *
     * @param  Business           $business Business holding the Contact
     * @param  Contact            $contact  Contact to destroy
     * @param  ContactFormRequest $request  Contact form Request
     * @return Response                     Redirect back to Business dashboard
     */
    public function destroy(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $this->log->info("BusinessContactController: destroy: businessId:{$business->id} contactId:{$contact->id}");
        $contact->businesses()->detach($business->id);

        Flash::success(trans('manager.contacts.msg.destroy.success'));
        return Redirect::route('manager.business.show', $business);
    }
}
