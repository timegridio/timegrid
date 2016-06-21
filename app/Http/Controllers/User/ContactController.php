<?php

namespace App\Http\Controllers\User;

use App\Events\NewContactWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterContactRequest;
use Notifynder;
use Request;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class ContactController extends Controller
{
    /**
     * create Contact.
     *
     * @param Business $business Business that holds the addressbook
     *                           for Contact
     *
     * @return Response Rendered form for Contact creation
     */
    public function create(Business $business)
    {
        logger()->info(__METHOD__);

        $user = auth()->user();

        // Search existing registered + email in same business
        $existingContact = $business->addressbook()->getRegisteredUserId($user->id);

        // Search existing subscribed email in same business
        if (!$existingContact) {
            $existingContact = $business->addressbook()->reuseExisting($user->email);
        }

        // Search existing any authenticated profile for user
        if (!$existingContact) {
            $existingContact = $user->contacts()->first();
        }

        if (!$existingContact) {
            $contact = new Contact(); // For Form Model Binding
            return view('user.contacts.create', compact('business', 'contact'));
        }

        logger()->info("[ADVICE] Found existing contact contactId:{$existingContact->id}");

        $contact = $business->addressbook()->copyFrom($existingContact, $user->id);

        flash()->success(trans('user.contacts.msg.store.associated_existing_contact'));

        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

    /**
     * store Contact.
     *
     * @param Business            $business Business that holds the Contact
     * @param AlterContactRequest $request  Alter Contact Request
     *
     * @return Response View for created Contact
     *                  or Redirect
     */
    public function store(Business $business, AlterContactRequest $request)
    {
        logger()->info(__METHOD__);

        // BEGIN

        $businessName = $business->name;
        Notifynder::category('user.subscribedBusiness')
                   ->from('App\Models\User', auth()->id())
                   ->to('Timegridio\Concierge\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName'))
                   ->send();

#        $existingContact = $business->addressbook()->reuseExisting($request->input('email'));
#
#        if ($existingContact) {
#            $existingContact->linktToUserId(auth()->id());
#            // auth()->user()->contacts()->save($existingContact);
#
#            flash()->warning(trans('user.contacts.msg.store.warning.already_registered'));
#
#            return redirect()->route('user.business.contact.show', [$business, $existingContact]);
#        }

        $contact = $business->addressbook()->register(Request::all());

        $business->addressbook()->linkToUserId($contact, auth()->id());

        event(new NewContactWasRegistered($contact));

        flash()->success(trans('user.contacts.msg.store.success'));

        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

    /**
     * show Contact.
     *
     * @param Business $business Business holding the Contact
     * @param Contact  $contact  Desired Contact to show
     *
     * @return Response Rendered view of Contact
     */
    public function show(Business $business, Contact $contact)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        $memberSince = $business->contacts()->find($contact->id)->pivot->created_at;

        $appointments = $contact->appointments()->orderBy('start_at')->ofBusiness($business->id)->active()->get();

        return view('user.contacts.show', compact('business', 'contact', 'appointments', 'memberSince'));
    }

    /**
     * edit Contact.
     *
     * @param Business            $business Business holding the Contact
     * @param Contact             $contact  Contact for edit
     * @param AlterContactRequest $request  Alter Contact Request
     *
     * @return Response Rendered view of Contact edit form
     */
    public function edit(Business $business, Contact $contact)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        return view('user.contacts.edit', compact('business', 'contact'));
    }

    /**
     * update Contact.
     *
     * @param Business            $business Business holding the Contact
     * @param Contact             $contact  Contact to update
     * @param AlterContactRequest $request  Alter Contact Request
     *
     * @return Response Redirect back to edited Contact
     */
    public function update(Business $business, Contact $contact, AlterContactRequest $request)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        $data = $request->only([
            'firstname',
            'lastname',
            'email',
            'nin',
            'gender',
            'birthdate',
            'mobile',
            'mobile_country',
        ]);

        $contact = $business->addressbook()->update($contact, $data, $request->get('notes'));

        flash()->success(trans('user.contacts.msg.update.success'));

        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

    /**
     * destroy Contact.
     *
     * @param Business $business Business holding the Contact
     * @param Contact  $contact  Contact to destroy
     *
     * @return Response Redirect back to Business show
     */
    public function destroy(Business $business, Contact $contact)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        $business->addressbook()->remove($contact);

        flash()->success(trans('user.contacts.msg.destroy.success'));

        return redirect()->route('user.business.contact.index', $business);
    }
}
