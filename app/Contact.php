<?php

namespace App;

use Carbon\Carbon;
use App\Business;

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'nin', 'email', 'birthdate', 'mobile', 'mobile_country', 'notes', 'gender', 'occupation', 'martial_status', 'postal_address'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birthdate'];

    /**
     * TODO: Check if possible to move to a more proper place
     *
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $changed = $this->getDirty();

        if (array_key_exists('email', $changed)) {
            $this->linkToUser(true);
        }
        return parent::save();
    }

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
        return $this->belongsTo('App\User');
    }

    /**
     * TODO: Check usage of this method, might need to be deprecated
     *       It is not safe to get just the first bussiness and there should be no need to use this
     *
     * belongs to Business
     * @return Illuminate\Database\Query Relationship Contact is part of Business' addressbook query
     */
    public function business(Business $business)
    {
        return $this->belongsToMany('App\Business')->withPivot('notes')->where('business_id', $business->id)->withTimestamps()->first();
    }

    /**
     * belongs to Business
     *
     * @return Illuminate\Database\Query Relationship Contact is part of Businesses addressbooks query
     */
    public function businesses()
    {
        return $this->belongsToMany('App\Business');
    }

    /**
     * has Appointments
     *
     * @return Illuminate\Database\Query Relationship Contact has booked Appointments query
     */
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
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
        return $this->hasMany('App\Appointment')->selectRaw('contact_id, count(*) as aggregate')->groupBy('contact_id');
    }

    /**
     * get AppointmentsCount
     *
     * @return integer Count of Appointments held by this Contact
     */
    public function getAppointmentsCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('appointmentsCount', $this->relations)) {
            $this->load('appointmentsCount');
        }
     
        $related = $this->getRelation('appointmentsCount');

        // then return the count directly
        return ($related->count()>0) ? (int) $related->first()->aggregate : 0;
    }

    ///////////////
    // Accessors //
    ///////////////

    /**
     * TODO: Move to Presenter
     *
     * get Full Name
     * @return string Concatenated firstname and lastname
     */
    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * get Username of associated User
     *
     * @return string Associated User's email address (if any)
     */
    public function getUsernameAttribute()
    {
        return ($this->user) ? $this->user->email : null;
    }

    /**
     * TODO: Probably needed to be moved to Presenter
     *
     * get Age
     *
     * @return int Age in years
     */
    public function getAgeAttribute()
    {
        if ($this->birthdate == null) {
            return null;
        }
        
        $reference = new \DateTime;
        $born = new \DateTime($this->birthdate);

        if ($this->birthdate > $reference) {
            return null;
        }

        $diff = $reference->diff($born);
        return $diff->y;
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
        $this->attributes['mobile'] = trim($mobile) ?: null;
    }

    /**
     * set Mobile Country
     *
     * @param string $country Country ISO Code ALPHA-2
     */
    public function setMobileCountryAttribute($country)
    {
        $this->attributes['mobile_country'] = trim($country) ?: null;
    }

    /**
     * set Birthdate
     *
     * @param string $birthdate Carbon parseable birth date
     */
    public function setBirthdateAttribute($birthdate)
    {
        $this->attributes['birthdate'] = trim($birthdate) ? Carbon::parse($birthdate) : null;
    }

    /**
     * set Email
     *
     * @param string $email Valid email address
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = trim($email) ?: null;
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
        $this->attributes['nin'] = trim($nin) ?: null;
    }

    /**
     * TODO: Check that might be reusable code from User.linkToContacts()
     *
     * link to User
     *
     * @param  boolean $force_relink Force relinking if already linked to a User
     * @return Contact               Current Contact already linked
     */
    public function linkToUser($force_relink = false)
    {
        if (trim($this->email) == '' || $this->user_id !== null && $force_relink == false) {
            return $this;
        }

        $user = \App\User::where(['email' => $this->email])->first();

        if ($user === null) {
            $this->unlinkUser();
        } else {
            $this->attributes['user_id'] = $user->id;
        }
        return $this;
    }

    /**
     * TODO: This method does not alter DB
     *       Seems to be a helper function that might need to get moved somewhere else
     *
     * unlink User
     *
     * @return Contact               Current Contact already unlinked
     */
    public function unlinkUser()
    {
        $this->attributes['user_id'] = null;

        return $this;
    }

    /////////////////////
    // Soft Attributes //
    /////////////////////

    /**
     * is Suscribed To Business
     *
     * @param  Business $business Business of inquiry
     * @return boolean            The Contact belongs to the inquired Business' addressbook
     */
    public function isSuscribedTo(Business $business)
    {
        return $this->businesses->contains($business);
    }

    /**
     * TODO: Check if needs to get moved to Presenter
     *
     * get Quality
     *
     * @return float Contact quality percentual score calculated from profile completion
     */
    public function getQualityAttribute()
    {
        $quality  = 0;
        $quality += $this->firstname ? 1 : 0;
        $quality += $this->lastname ? 1 : 0;
        $quality += $this->nin ? 5 : 0;
        $quality += $this->birthdate ? 2 : 0;
        $quality += $this->mobile ? 4 : 0;
        $quality += $this->email ? 4 : 0;
        $quality += $this->postal_address ? 3 : 0;
        $total    = 20;
        return $quality/$total*100;
    }
}
