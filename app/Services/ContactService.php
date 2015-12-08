<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Business;
use App\Events\NewRegisteredContact;

/*******************************************************************************
 * Contact Service Layer
 ******************************************************************************/
class ContactService
{
    /**
     * [register description]
     *
     * @param  User     $user     [description]
     * @param  Business $business [description]
     * @param  [type]   $data     [description]
     * @return [type]             [description]
     */
    public function register(User $user, Business $business, $data)
    {
        if (false === $contact = self::getExisting($user, $business, $data['nin'])) {
            $contact = Contact::create($data);
            $business->contacts()->attach($contact);

            logger()->info("Contact created contactId:{$contact->id}");

            self::updateNotes($business, $contact, $data['notes']);
        }

        event(new NewRegisteredContact($contact));

        return $contact;
    }

    /**
     * [getExisting description]
     *
     * @param  User     $user     [description]
     * @param  Business $business [description]
     * @param  [type]   $nin      [description]
     * @return [type]             [description]
     */
    public function getExisting(User $user, Business $business, $nin)
    {
        if (trim($nin) == '') {
            return false;
        }

        $existingContacts = Contact::whereNotNull('nin')->where(['nin' => $nin])->get();

        foreach ($existingContacts as $existingContact) {
            logger()->info("[ADVICE] Found existing contactId:{$existingContact->id}");

            if ($existingContact->isSubscribedTo($business->id)) {
                logger()->info('[ADVICE] Existing contact is already linked to business');
                
                return $existingContact;
            }
        }
        return false;
    }

    /**
     * [find description]
     *
     * @param  Business $business [description]
     * @param  Contact  $contact  [description]
     * @return [type]             [description]
     */
    public function find(Business $business, Contact $contact)
    {
        return $business->contacts()->find($contact->id);
    }

    public function update(Business $business, Contact $contact, $data = [], $notes = null)
    {
        if(array_key_exists('birthdate', $data) && trim($data['birthdate']) != '')
        {
            $data['birthdate'] = Carbon::createFromFormat(trans('app.dateformat.carbon'), $data['birthdate']);
        }

        $contact->where('id', '=', $contact->id)->update($data);

        self::updateNotes($business, $contact, $notes);
    }

    protected function updateNotes(Business $business, Contact $contact, $notes)
    {
        if ($notes) {
            $business->contacts()->find($contact->id)->pivot->update(['notes' => $notes]);
        }
    }

    public function detach(Business $business, Contact $contact)
    {
        return $contact->businesses()->detach($business->id);
    }
}
