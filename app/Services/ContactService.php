<?php

namespace App\Services;

use App\Events\NewContactWasRegistered;
use App\Models\Business;
use App\Models\Contact;
use App\Models\User;

/*******************************************************************************
 * Contact Service Layer
 ******************************************************************************/
class ContactService
{
    /**
     * Register a new Contact.
     *
     * @param User     $user
     * @param Business $business
     * @param array    $data
     *
     * @return App\Models\Contact
     */
    public function register(User $user, Business $business, $data)
    {
        if (false === $contact = self::getExisting($user, $business, $data['nin'])) {
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
     * @return App\Models\Contact
     */
    public function copyFrom(User $user, Business $business, Contact $existingContact)
    {
        $contact = Contact::create($existingContact->toArray());
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
     * @return App\Models\Contact
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
     * @param User     $user
     * @param Business $business
     * @param string   $nin
     *
     * @return App\Models\Contact
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
     * @return App\Models\Contact
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
        $contact->firstname = $data['firstname'];
        $contact->lastname = $data['lastname'];
        $contact->email = $data['email'];
        $contact->nin = $data['nin'];
        $contact->gender = $data['gender'];
        $contact->birthdate = $data['birthdate'];
        $contact->mobile = $data['mobile'];
        $contact->mobile_country = $data['mobile_country'];

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
}
