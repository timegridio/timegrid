<?php

namespace App\Http\Controllers\Manager;

use App\Events\NewContactWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class AddressbookController extends Controller
{
    /**
     * index of Contacts for Business.
     *
     * @param Business $business Business that holds the Contacts
     *
     * @return Response Rendered view of Contact addressbook
     */
    public function index(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageContacts', $business);

        $contacts = $business->addressbook()->listing(100);

        return view('manager.contacts.index', compact('business', 'contacts'));
    }

    /**
     * create Contact.
     *
     * @param Business           $business Business that will hold the Contact
     * @param ContactFormRequest $request  Contact form Request
     *
     * @return Response Rendered form for Contact creation
     */
    public function create(Business $business, ContactFormRequest $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageContacts', $business);

        // BEGIN //

        $contact = new Contact(); // For Form Model Binding

        return view('manager.contacts.create', compact('business', 'contact'));
    }

    /**
     * store Contact.
     *
     * @param Business           $business Business that will hold the Contact
     * @param ContactFormRequest $request  Contact form Request
     *
     * @return Response Rendered view or Redirect
     */
    public function store(Business $business, ContactFormRequest $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manageContacts', $business);

        // BEGIN //

        $contact = $business->addressbook()->register($request->all());

        if (!$contact->wasRecentlyCreated) {
            flash()->warning(trans('manager.contacts.msg.store.warning_showing_existing_contact'));

            return redirect()->route('manager.addressbook.show', [$business, $contact]);
        }

        event(new NewContactWasRegistered($contact));

        flash()->success(trans('manager.contacts.msg.store.success'));

        return redirect()->route('manager.addressbook.show', [$business, $contact]);
    }

    /**
     * show Contact.
     *
     * @param Business           $business Business holding the Contact
     * @param Contact            $contact  Contact to show
     * @param ContactFormRequest $request  Contact form Request
     *
     * @return Response Rendered view of Contact show
     */
    public function show(Business $business, Contact $contact)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manageContacts', $business);

        // BEGIN //
        $contact = $business->addressbook()->find($contact);

        return view('manager.contacts.show', compact('business', 'contact'));
    }

    /**
     * edit Contact.
     *
     * @param Business $business Business holding the Contact
     * @param Contact  $contact  Contact to edit
     *
     * @return Response Rendered view of edit form
     */
    public function edit(Business $business, Contact $contact)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manageContacts', $business);

        // BEGIN //

        $contact = $business->addressbook()->find($contact);

        $notes = $contact->pivot->notes;

        return view('manager.contacts.edit', compact('business', 'contact', 'notes'));
    }

    /**
     * update Contact.
     *
     * @param Business           $business Business holding the Contact
     * @param Contact            $contact  Contact to update
     * @param ContactFormRequest $request  Contact form Request
     *
     * @return Response Redirect to updated Contact show
     */
    public function update(Business $business, Contact $contact, ContactFormRequest $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manageContacts', $business);

        // BEGIN //

        $data = $request->only([
            'firstname',
            'lastname',
            'email',
            'nin',
            'gender',
            'birthdate',
            'mobile',
            'mobile_country',
            'postal_address',
        ]);

        $contact = $business->addressbook()->update($contact, $data, $request->get('notes'));

        // FEATURE: If email was updated, user linking should be triggered (if contact is not owned)

        flash()->success(trans('manager.contacts.msg.update.success'));

        return redirect()->route('manager.addressbook.show', [$business, $contact]);
    }

    /**
     * destroy Contact.
     *
     * @param Business $business Business holding the Contact
     * @param Contact  $contact  Contact to destroy
     *
     * @return Response Redirect back to Business dashboard
     */
    public function destroy(Business $business, Contact $contact)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manageContacts', $business);

        // BEGIN //

        $contact = $business->addressbook()->remove($contact);

        // FEATURE: If user is linked to contact, inform removal

        flash()->success(trans('manager.contacts.msg.destroy.success'));

        return redirect()->route('manager.addressbook.index', $business);
    }
}
