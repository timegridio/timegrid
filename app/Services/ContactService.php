<?php

namespace App\Services;

use App\Events\NewContactWasRegistered;
use App\Models\User;
use Carbon\Carbon;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

/*******************************************************************************
 * Contact Service Layer
 ******************************************************************************/
class ContactService
{
    /**
     * Register a new Contact.
     *
     * @param Business $business
     * @param array    $data
     *
     * @return Timegridio\Concierge\Models\Contact
     */
    public function register(Business $business, $data)
    {
        if (false === $contact = self::getExisting($business, $data['nin'])) {
            #$data['birthdate'] = $data['birthdate'] != '' ? Carbon::parse($data['birthdate']) : null;
            $this->sanitizeDate($data['birthdate']);

            $contact = Contact::create($data);

            $business->contacts()->attach($contact);
            $business->save();

            logger()->info("Contact created contactId:{$contact->id}");

            if (array_key_exists('notes', $data)) {
                self::updateNotes($business, $contact, $data['notes']);
            }
        }

        event(new NewContactWasRegistered($contact));

        return $contact;
    }

    /**
     * Copy Contact from provided exiting.
     *
     * @param User     $user
     * @param Business $business
     * @param Contact  $existingContact
     *
     * @return Timegridio\Concierge\Models\Contact
     */
    public function copyFrom(User $user, Business $business, Contact $existingContact)
    {
        $existingContactData = $existingContact->toArray();

        $this->sanitizeDate($existingContactData['birthdate']);

        $contact = Contact::create($existingContactData);
        $contact->user()->associate($user->id);
        $contact->businesses()->detach();
        $contact->save();

        $business->contacts()->attach($contact);
        $business->save();

        return $contact;
    }

    /**
     * Associate Contact with User.
     *
     * @param Contact $contact
     * @param User    $user
     *
     * @return Timegridio\Concierge\Models\Contact
     */
    public function linkToUser(Contact $contact, User $user)
    {
        $contact->user()->associate($user->id);
        $contact->save();

        return $contact->fresh();
    }

    /**
     * Find an existing contact with the same NIN.
     *
     * @param Business $business
     * @param string   $nin
     *
     * @return Timegridio\Concierge\Models\Contact
     */
    public function getExisting(Business $business, $nin)
    {
        if (trim($nin) == '') {
            return false;
        }

        $existingContacts = $business->contacts()->whereNotNull('nin')->where(['nin' => $nin])->get();

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
     * Find an existing Contact By UserId.
     *
     * @param int $userId
     *
     * @return Collection|Builder
     */
    public function findExistingContactsByUserId($userId)
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
    public function findExistingContactsByEmail($email)
    {
        return Contact::whereNull('user_id')
            ->whereNotNull('email')
            ->where('email', '<>', '')
            ->where(['email' => $email])
            ->get();
    }

    /**
     * Find a contact within a Business addressbok.
     *
     * @param Business $business
     * @param Contact  $contact
     *
     * @return Timegridio\Concierge\Models\Contact
     */
    public function find(Business $business, Contact $contact)
    {
        return $business->contacts()->find($contact->id);
    }

    /**
     * Update Contact attributes.
     *
     * @param Business $business
     * @param Contact  $contact
     * @param array    $data
     * @param string   $notes
     *
     * @return void
     */
    public function update(Business $business, Contact $contact, $data = [], $notes = null)
    {
        $birthdate = array_get($data, 'birthdate');
        $this->sanitizeDate($birthdate);

        $contact->firstname = array_get($data, 'firstname');
        $contact->lastname = array_get($data, 'lastname');
        $contact->email = array_get($data, 'email');
        $contact->nin = array_get($data, 'nin');
        $contact->gender = array_get($data, 'gender');
        $contact->birthdate = $birthdate;
        $contact->mobile = array_get($data, 'mobile');
        $contact->mobile_country = array_get($data, 'mobile_country');
        $contact->postal_address = array_get($data, 'postal_address');

        $contact->save();

        self::updateNotes($business, $contact, $notes);

        return $contact;
    }

    /**
     * Detach a Contact froma Business addressbok.
     *
     * @param Business $business
     * @param Contact  $contact
     *
     * @return int
     */
    public function detach(Business $business, Contact $contact)
    {
        return $contact->businesses()->detach($business->id);
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * Update notes from pivot table.
     *
     * @param Business $business
     * @param Contact  $contact
     * @param string   $notes
     *
     * @return void
     */
    protected function updateNotes(Business $business, Contact $contact, $notes = null)
    {
        if ($notes) {
            $business->contacts()->find($contact->id)->pivot->update(['notes' => $notes]);
        }
    }

    protected function sanitizeDate(&$value)
    {
        if (!is_string($value)) {
            return $value;
        }

        if (trim($value) == '') {
            return $value = null;
        }

        if (strlen($value) == 19) {
            return $value = Carbon::parse($value);
        }

        if (strlen($value) == 10) {
            return $value = Carbon::createFromFormat(trans('app.dateformat.carbon'), $value);
        }
    }
}
