<?php

namespace App\Http\Controllers\User;

use Flash;
use Request;
use Notifynder;
use App\Http\Requests;
use App\Models\Contact;
use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\ViewContactRequest;
use App\Http\Requests\AlterContactRequest;

class BusinessContactController extends Controller
{
    /**
     * create Contact
     *
     * @param  Business  $business Business that holds the addressbook
     *                             for Contact
     * @return Response            Rendered form for Contact creation
     */
    public function create(Business $business)
    {
        $this->log->info(__METHOD__);

#        $existing_contact = Contact::where(['email' => auth()->user()->email])->get()->first();
#
#        if ($existing_contact !== null && !$existing_contact->isSubscribedTo($business)) {
#            $this->log->info("BusinessContactController: create: [ADVICE] Found existing contact contactId:{$existing_contact->id}");
#            $business->contacts()->attach($existing_contact);
#            $business->save();
#            Flash::success(trans('user.contacts.msg.store.associated_existing_contact'));
#            return redirect()->route('user.business.contact.show', [$business, $existing_contact]);
#        }

        $contact = new Contact; // For Form Model Binding
        return view('user.contacts.create', compact('business', 'contact'));
    }

    /**
     * store Contact
     *
     * @param  Business            $business Business that holds the Contact
     * @param  AlterContactRequest $request  Alter Contact Request
     * @return Response                      View for created Contact
     *                                       or Redirect
     */
    public function store(Business $business, AlterContactRequest $request)
    {
        $this->log->info(__METHOD__);

        $business_name = $business->name;
        Notifynder::category('user.subscribedBusiness')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        $existing_contacts = Contact::whereNull('user_id')->whereNotNull('email')->where('email', '<>', '')->where(['email' => $request->input('email')])->get();

        foreach ($existing_contacts as $existing_contact) {
            if ($existing_contact->isSubscribedTo($business)) {
                auth()->user()->contacts()->save($existing_contact);

                Flash::warning(trans('user.contacts.msg.store.warning.already_registered'));
                return redirect()->route('user.business.contact.show', [$business, $existing_contact]);
            }
            $business->contacts()->attach($existing_contact);
            $business->save();
            Flash::warning(trans('user.contacts.msg.store.warning.showing_existing_contact'));
            return redirect()->route('user.business.contact.show', [$business, $existing_contact]);
        }

        $contact = Contact::create(Request::all());
        $contact->user()->associate(auth()->user()->id);
        $contact->save();
        $business->contacts()->attach($contact);
        $business->save();

        Flash::success(trans('user.contacts.msg.store.success'));
        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

    /**
     * show Contact
     *
     * @param  Business           $business Business holding the Contact
     * @param  Contact            $contact  Desired Contact to show
     * @param  ViewContactRequest $request  Read access Request
     * @return Response                     Rendered view of Contact
     */
    public function show(Business $business, Contact $contact, ViewContactRequest $request)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("  businessId:%s contactId:%s",
            $business->id,
            $contact->id
            ));

        return view('user.contacts.show', compact('business', 'contact'));
    }

    /**
     * edit Contact
     *
     * @param  Business            $business Business holding the Contact
     * @param  Contact             $contact  Contact for edit
     * @param  AlterContactRequest $request  Alter Contact Request
     * @return Response                      Rendered view of Contact edit form
     */
    public function edit(Business $business, Contact $contact, AlterContactRequest $request)
    {
        $this->log->info("BusinessContactController: edit: businessId:{$business->id} contactId:{$contact->id}");
        return view('user.contacts.edit', compact('business', 'contact'));
    }

    /**
     * update Contact
     *
     * @param  Business            $business Business holding the Contact
     * @param  Contact             $contact  Contact to update
     * @param  AlterContactRequest $request  Alter Contact Request
     * @return Response                      Redirect back to edited Contact
     */
    public function update(Business $business, Contact $contact, AlterContactRequest $request)
    {
        $this->log->info("BusinessContactController: update: businessId:{$business->id} contactId:{$contact->id}");
        $update = [
            'mobile'          => $request->get('mobile'),
            'mobile_country'  => $request->get('mobile_country')
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
        $this->log->info("BusinessContactController: update: Updated contact");

        Flash::success(trans('user.contacts.msg.update.success'));
        return redirect()->route('user.business.contact.show', [$business, $contact]);
    }

    /**
     * TODO: Destroying a Contact should cascade-delete all belonging elements
     *
     * destroy Contact
     *
     * @param  Business           $business Business holding the Contact
     * @param  Contact            $contact  Contact to destroy
     * @param  ContactFormRequest $request  Contact Form Request
     * @return Response                     Redirect back to Business show
     */
    public function destroy(Business $business, Contact $contact, ContactFormRequest $request)
    {
        $contact->delete();
        $this->log->info("BusinessContactController: destroy: Deleted contact:{$contact->id}");

        Flash::success(trans('manager.contacts.msg.destroy.success'));
        return redirect()->route('manager.business.show', $business);
    }
}
