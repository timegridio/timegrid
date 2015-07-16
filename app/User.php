<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kodeine\Acl\Traits\HasRole;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasRole;

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
    protected $fillable = ['email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function businesses()
    {
        return $this->belongsToMany('App\Business')->withTimestamps();
    }

    public function allBusinesses()
    {
        return $this->belongsToMany('App\Business')->withTrashed()->withTimestamps();
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function appointments()
    {
        return $this->hasManyThrough('App\Appointment', 'App\Contact');
    }

    public function suscribedTo(Business $business)
    {
        return $this->contacts->filter(function ($contact) use ($business) {
            return $contact->isSuscribedTo($business);
        })->first();
    }

    public function isOwner(Business $business)
    {
        return $this->allBusinesses->contains($business);
    }

    public function hasBusiness()
    {
        return $this->businesses->count() > 0;
    }

    public function linkToContacts()
    {
        if(trim($this->email) == '') return false;

        $contacts = \App\Contact::where(['email' => $this->email])->whereNotNull('email')->whereNull('user_id')->get();

        foreach ($contacts as $contact) {
            $contact->user()->associate($this)->save();
        }
    }
}
