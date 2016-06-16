<?php

namespace App\Http\Controllers\User;

use App\Events\NewContactWasRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlterContactRequest;
use App\Services\ContactService;
use Notifynder;
use Request;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class ContactController extends Controller
{
    /**
     * Contact service implementation.
     *
     * @var App\Services\ContactService
     */
    private $contactService;

    /**
     * Create controller.
     *
     * @param App\Services\ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;

        parent::__construct();
    }

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

        $existingContacts = $this->contactService->findExistingContactsByUserId(auth()->id());

        $user = auth()->user();

        if ($existingContacts->isEmpty()) {
            $existingContacts = $this->contactService->findExistingContactsByEmail($user->email);
        }

        foreach ($existingContacts as $existingContact) {
            if ($existingContact !== null && !$existingContact->isSubscribedTo($business)) {
                logger()->info("[ADVICE] Found existing contact contactId:{$existingContact->id}");
                $contact = $this->contactService->copyFrom($user, $business, $existingContact);

                flash()->success(trans('user.contacts.msg.store.associated_existing_contact'));

                return redirect()->route('user.business.contact.show', [$business, $contact]);
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
        logger()->info(__METHOD__);

        // BEGIN

        $businessName = $business->name;
        Notifynder::category('user.subscribedBusiness')
                   ->from('App\Models\User', auth()->id())
                   ->to('Timegridio\Concierge\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName'))
                   ->send();

        $existingContacts = $this->contactService->findExistingContactsByEmail($request->input('email'));

        foreach ($existingContacts as $existingContact) {
            if ($existingContact->isSubscribedTo($business)) {
                auth()->user()->contacts()->save($existingContact);

                flash()->warning(trans('user.contacts.msg.store.warning.already_registered'));

                return redirect()->route('user.business.contact.show', [$business, $existingContact]);
            }
        }

        $contact = $this->contactService->register($business, Request::all());

        $this->contactService->linkToUser($contact, auth()->user());

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

        $contact = $this->contactService->update($business, $contact, $data, $request->get('notes'));

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

        $this->contactService->detach($business, $contact);

        flash()->success(trans('user.contacts.msg.destroy.success'));

        return redirect()->route('user.business.contact.index', $business);
    }
}
