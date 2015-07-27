<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kodeine\Acl\Traits\HasRole;
use Fenos\Notifynder\Notifable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasRole, Notifable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    ///////////////////
    // Relationships //
    ///////////////////

    /**
     * owns Business
     * @return Illuminate\Database\Query Relationship Business belongs to User query
     */
    public function businesses()
    {
        return $this->belongsToMany('App\Business')->withTimestamps();
    }

    /**
     * has Contacts
     *
     * Contacts are the different profiles for different Businesses the User may have
     * 
     * @return Illuminate\Database\Query Relationship User has Contacts query
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    /**
     * holds Appointments through Contacts
     *
     * The Appointments are the Contact reservations held by this User
     * 
     * @return Illuminate\Database\Query Relationship User has Appointments through Contacts query
     */
    public function appointments()
    {
        return $this->hasManyThrough('App\Appointment', 'App\Contact');
    }

    /////////////////////
    // Soft Attributes //
    /////////////////////

    /**
     * TODO: Rename to isOwnerOf()
     * 
     * is Owner of Business
     * @param  Business $business Business to inquiry against
     * @return boolean            The User is Owner of the inquired Business
     */
    public function isOwner(Business $business)
    {
        return $this->businesses()->withTrashed()->get()->contains($business);
    }

    /**
     * has Business
     * @return boolean The User is Owner of at least one Business
     */
    public function hasBusiness()
    {
        return $this->businesses->count() > 0;
    }

    /**
     * has Contacts
     * @return boolean The User has at least one Contact profile set
     */
    public function hasContacts()
    {
        return $this->contacts->count() > 0;
    }

    //////////////
    // Mutators //
    //////////////

    /**
     * set Name
     * @param string $string The first name of the User
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords(strtolower($name));
    }

    /**
     * TODO: Rename to getContactSuscribedTo()
     * 
     * Get Suscribed Contact to Business
     * @param  Business $business Business of inquiry
     * @return Contact            User profile Contact suscribed to the inquired Business
     */
    public function suscribedTo(Business $business)
    {
        return $this->contacts->filter(function ($contact) use ($business) {
            return $contact->isSuscribedTo($business);
        })->first();
    }

    /**
     * TODO: Review the logic of this method.
     *       The method may return true even when no Contacts were found
     *       Should return the Contact Collection that were associated
     * 
     * Link to Contacts
     * @return boolean The User was linked to at least one Contact
     */
    public function linkToContacts()
    {
        if (trim($this->email) == '') {
            return false;
        }

        $contacts = \App\Contact::where(['email' => $this->email])->whereNotNull('email')->whereNull('user_id')->get();

        foreach ($contacts as $contact) {
            $contact->user()->associate($this)->save();
        }
        return true;
    }
}
