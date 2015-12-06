<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Business;
use App\Presenters\ContactPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Contact extends EloquentModel implements HasPresenter
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'nin', 'email', 'birthdate', 'mobile', 'mobile_country', 'notes',
                            'gender', 'occupation', 'martial_status', 'postal_address'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birthdate'];

    //////////////////
    // Relationship //
    //////////////////

    /**
     * is profile of User
     *
     * @return Illuminate\Database\Query Relationship Contact belongs to User query
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * indicates if contact belongs to Business
     *
     * @return Illuminate\Database\Query Relationship Contact is part of Business' addressbook query
     */
    public function isOnAddressbookOf(Business $business)
    {
        return $this->businesses()->contains($business);
    }

    /**
     * belongs to Business
     *
     * @return Illuminate\Database\Query Relationship Contact is part of Businesses addressbooks query
     */
    public function businesses()
    {
        return $this->belongsToMany('App\Models\Business');
    }

    /**
     * has Appointments
     *
     * @return Illuminate\Database\Query Relationship Contact has booked Appointments query
     */
    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment');
    }

    /**
     * has Appointment
     *
     * @return Illuminate\Database\Query Relationship Contact has first booked Appointment query
     */
    public function appointment()
    {
        return $this->appointments->first();
    }

    /////////////////////
    // Soft Attributes //
    /////////////////////

    /**
     * has Appointment
     *
     * @return boolean Check if Contact has at least one Appointment booked
     */
    public function hasAppointment()
    {
        return $this->appointmentsCount > 0;
    }

    /**
     * Appointments Count
     *
     * This method is used to optimize the relationship counting performance
     *
     * @return Illuminate\Database\Query Relationship Contact x Appointment count(*) query
     */
    public function appointmentsCount()
    {
        return $this
            ->hasMany('App\Models\Appointment')
            ->selectRaw('contact_id, count(*) as aggregate')
            ->groupBy('contact_id');
    }

    /**
     * get AppointmentsCount
     *
     * @return integer Count of Appointments held by this Contact
     */
    public function getAppointmentsCountAttribute()
    {
        # If relation is not loaded already, let's do it first
        if (! array_key_exists('appointmentsCount', $this->relations)) {
            $this->load('appointmentsCount');
        }
     
        $related = $this->getRelation('appointmentsCount');

        # Then return the count directly
        return ($related->count()>0) ? (int) $related->first()->aggregate : 0;
    }

    ///////////////
    // Presenter //
    ///////////////

    /**
     * get presenter
     *
     * @return ContactPresenter    Presenter class
     */
    public function getPresenterClass()
    {
        return ContactPresenter::class;
    }

    //////////////
    // Mutators //
    //////////////

    /**
     * set Mobile
     *
     * Expected phone number is international format numeric only
     *
     * @param string $mobile Mobile phone number
     */
    public function setMobileAttribute($mobile)
    {
        return $this->attributes['mobile'] = trim($mobile) ?: null;
    }

    /**
     * set Mobile Country
     *
     * @param string $country Country ISO Code ALPHA-2
     */
    public function setMobileCountryAttribute($country)
    {
        return $this->attributes['mobile_country'] = trim($country) ?: null;
    }

    /**
     * set Birthdate
     *
     * @param string $birthdate Carbon parseable birth date
     */
    public function setBirthdateAttribute($birthdate)
    {
        return $this->attributes['birthdate'] =
            trim($birthdate) ? Carbon::createFromFormat(trans('app.dateformat.carbon'), $birthdate) : null;
    }

    /**
     * set Email
     *
     * @param string $email Valid email address
     */
    public function setEmailAttribute($email)
    {
        return $this->attributes['email'] = trim($email) ?: null;
    }

    /**
     * TODO: Check if possible to handle in a more structured way
     *       NIN record is currently too flexible
     *
     * set NIN: National Identity Number
     *
     * @param string $nin The national identification number in any format
     */
    public function setNinAttribute($nin)
    {
        return $this->attributes['nin'] = trim($nin) ?: null;
    }

    /**
     * link Contact to existing User if any
     *
     * @return Contact    Current Contact linked to user
     */
    public function autoLinkToUser()
    {
        if ($this->email === null) {
            return $this;
        }
        
        $user = User::where(['email' => $this->email])->first();

        if ($user === null) {
            $this->user()->dissociate();
            $this->save();
            return $this;
        }
        
        $this->user()->associate($user);
        $this->save();
        return $this;
    }

    /////////////////////
    // Soft Attributes //
    /////////////////////

    /**
     * is Subscribed To Business
     *
     * @param  Business $business Business of inquiry
     * @return boolean            The Contact belongs to the inquired Business' addressbook
     */
    public function isSubscribedTo(Business $business)
    {
        return $this->businesses->contains($business);
    }

    /**
     * is Profile of User
     *
     * @param  User $user         User of inquiry
     * @return boolean            The Contact belongs to the inquired User
     */
    public function isProfileOf(User $user)
    {
        return $this->user ? $this->user->id == $user->id : false;
    }
}
