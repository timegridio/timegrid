<?php

namespace App\Models;

use App\Models\Contact;
use App\Traits\HasRoles;
use Fenos\Notifynder\Notifable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends EloquentModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasRoles, Notifable;

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
    protected $fillable = ['name', 'email', 'username', 'password'];

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
     *
     * @return Illuminate\Database\Query Relationship Business belongs to User query
     */
    public function businesses()
    {
        return $this->belongsToMany('App\Models\Business')->withTimestamps();
    }

    /**
     * has Contacts
     *
     *      Contacts are the different profiles for different Businesses the User may have
     *
     * @return Illuminate\Database\Query Relationship User has Contacts query
     */
    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
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
        return $this->hasManyThrough('App\Models\Appointment', 'App\Models\Contact');
    }

    /////////////////////
    // Soft Attributes //
    /////////////////////

    /**
     * TODO: Rename to isOwnerOf()
     *
     * is Owner of Business
     *
     * @param  int      $businessId Business to inquiry against
     * @return boolean              The User is Owner of the inquired Business
     */
    public function isOwner($businessId)
    {
        return $this->businesses()->withTrashed()->get()->contains($businessId);
    }

    /**
     * has Business
     *
     * @return boolean The User is Owner of at least one Business
     */
    public function hasBusiness()
    {
        return $this->businesses->count() > 0;
    }

    /**
     * has Contacts
     *
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
     * set Username
     *
     * @param string $username The desired username
     */
    public function setUsernameAttribute($username)
    {
        return $this->attributes['username'] = trim($username) != '' ? strtolower($username) : md5(time().uniqid());
    }

    /**
     * set Name
     *
     * @param string $string The first name of the User
     */
    public function setNameAttribute($name)
    {
        return $this->attributes['name'] = ucwords(strtolower($name));
    }

    /**
     * Get Subscribed Contact to Business
     *
     * @param  Business $business Business of inquiry
     * @return Contact            User profile Contact subscribed to the inquired Business
     */
    public function getContactSubscribedTo($businessId)
    {
        return $this->contacts->filter(function ($contact) use ($businessId) {
            return $contact->isSubscribedTo($businessId);
        })->first();
    }

    /**
     * Get the first record matching the email or create it.
     *
     * @param  array  $attributes
     * @return self
     */
    public static function firstOrCreate(array $attributes)
    {
        if (! is_null($instance = static::where('email', $attributes['email'])->first())) {
            return $instance;
        }

        return static::create($attributes);
    }

    /**
     * Link User to existing Contacts
     *
     * @return boolean   The User was linked to at least one Contact
     */
    public function linkToContacts()
    {
        $contacts = Contact::where(['email' => $this->email])->whereNotNull('email')->whereNull('user_id')->get();

        if ($contacts->isEmpty()) {
            return false;
        }

        foreach ($contacts as $contact) {
            $contact->user()->associate($this)->save();
        }
        return true;
    }
}
