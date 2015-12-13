<?php

namespace App\Http\Controllers\User;

use App\Events\NewRegisteredContact;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterContactRequest;
use App\Models\Business;
use App\Models\Contact;
use Flash;
use Notifynder;
use Request;

class BusinessContactController extends Controller
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
        $this->log->info(__METHOD__);

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $existingContacts = $this->findExistingContactsByUserId(auth()->user()->id);

        if ($existingContacts->isEmpty()) {
            $existingContacts = $this->findExistingContactsByEmail(auth()->user()->email);
        }

        foreach ($existingContacts as $existingContact) {
            if ($existingContact !== null && !$existingContact->isSubscribedTo($business)) {
                $this->log->info("[ADVICE] Found existing contact contactId:{$existingContact->id}");
                $newContact = Contact::create($existingContact->toArray());
                $newContact->user()->associate(auth()->user()->id);
                $newContact->businesses()->detach();
                $newContact->save();

                $business->contacts()->attach($newContact);
                $business->save();

                Flash::success(trans('user.contacts.msg.store.associated_existing_contact'));

                return redirect()->route('user.business.contact.show', [$business, $newContact]);
            }
        }

        $contact = new Contact(); // For Form Model Binding
        return view('user.contacts.create', compact('business', 'contact'));
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
        $this->log->info(__METHOD__);

        // BEGIN

        $businessName = $business->name;
        Notifynder::category('user.subscribedBusiness')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName'))
                   ->send();

        $existingContacts = $this->findExistingContactsByEmail($request->input('email'));

        foreach ($existingContacts as $existingContact) {
            if ($existingContact->isSubscribedTo($business)) {
                auth()->user()->contacts()->save($existingContact);

                Flash::warning(trans('user.contacts.msg.store.warning.already_registered'));

                return redirect()->route('user.business.contact.show', [$business, $existingContact]);
            }
        }

        $contact = Contact::create(Request::all());
        $contact->user()->associate(auth()->user()->id);
        $contact->save();
        $business->contacts()->attach($contact);
        $business->save();

        event(new NewRegisteredContact($contact));

        Flash::success(trans('user.contacts.msg.store.success'));

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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        # $memberSince = $business->contacts()->find($contact->id)->pivot->created_at;

        return view('user.contacts.show', compact('business', 'contact'));
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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $update = [
            'mobile'          => $request->get('mobile'),
            'mobile_country'  => $request->get('mobile_country'),
        ];

        /* Only allow filling empty fields, not modification */
        if ($contact->birthdate === null && $request->get('birthdate')) {
            $update['birthdate'] = $request->get('birthdate');
            $this->log->info("BusinessContactController: update: Updated birthdate:{$update['birthdate']}");
        }
        if (trim($contact->nin) == '' && $request->get('nin')) {
            $update['nin'] = $request->get('nin');
            $this->log->info("BusinessContactController: update: Updated nin:{$update['nin']}");
        }

        $contact->update($update);
        $this->log->info('BusinessContactController: update: Updated contact');

        Flash::success(trans('user.contacts.msg.update.success'));

        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

    /**
     * destroy Contact.
     *
     * @param Business           $business Business holding the Contact
     * @param Contact            $contact  Contact to destroy
     * @param ContactFormRequest $request  Contact Form Request
     *
     * @return Response Redirect back to Business show
     */
    public function destroy(Business $business, Contact $contact)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $contact);

        // BEGIN

        $contact->delete();

        Flash::success(trans('manager.contacts.msg.destroy.success'));

        return redirect()->route('manager.business.show', $business);
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * Find an existing Contact By UserId.
     *
     * @param int $userId
     *
     * @return Collection|Builder
     */
    protected function findExistingContactsByUserId($userId)
    {
        return Contact::where('user_id', '=', $userId)->get();
    }

    /**
     * Find an existing Contact By Email.
     *
     * @param string $email
     *
     * @return Collection|Builder
     */
    protected function findExistingContactsByEmail($email)
    {
        return Contact::whereNull('user_id')
            ->whereNotNull('email')
            ->where('email', '<>', '')
            ->where(['email' => $email])
            ->get();
    }
}
