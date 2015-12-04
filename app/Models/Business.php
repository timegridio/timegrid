<?php

namespace App\Models;

use App\Traits\Preferenceable;
use Fenos\Notifynder\Notifable;
use App\Presenters\BusinessPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Business extends EloquentModel
{
    use Notifable, SoftDeletes, Preferenceable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'timezone', 'postal_address',
        'phone', 'social_facebook', 'strategy', 'plan'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Create Business model
     * @param array $attributes Attributes for filling the model
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setSlugAttribute();
    }

    ///////////////////
    // Relationships //
    ///////////////////

    /**
     * belongs to Category
     *
     * @return Illuminate\Database\Query Relationship Business Category query
     */
    public function category()
    {
        /* TODO: Use cache here? */
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * holds Contacts
     *
     * @return Illuminate\Database\Query Relationship Business held Contacts query
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Models\Contact')
                    ->with('user')
                    ->withPivot('notes')
                    ->withTimestamps();
    }

    /**
     * provides Services
     *
     * @return Illuminate\Database\Query Relationship Business provided Services query
     */
    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    /**
     * publishes Vacancies
     *
     * @return Illuminate\Database\Query Relationship Business published Vacancies query
     */
    public function vacancies()
    {
        return $this->hasMany('App\Models\Vacancy');
    }

    /**
     * ToDo: Should be renamed to "appointments"
     * holds Appointments booking
     *
     * @return Illuminate\Database\Query Relationship Business holds Appointments query
     */
    public function bookings()
    {
        return $this->hasMany('App\Models\Appointment');
    }

    /**
     * belongs to Users
     *
     * @return Illuminate\Database\Query Relationship Business belongs to User (owners) query
     */
    public function owners()
    {
        /* TODO: Use cache here? */
        return $this->belongsToMany(config('auth.model'))->withTimestamps();
    }

    /**
     * belongs to User
     *
     * @return User Relationship Business belongs to User (owner)
     */
    public function owner()
    {
        /* TODO: Use cache here? */
        return $this->belongsToMany(config('auth.model'))->withTimestamps()->first();
    }

    /**
     * Get the real Users subscriptions count
     *
     * @return Illuminate\Database\Query Relationship
     */
    public function subscriptionsCount()
    {
        return $this->belongsToMany('App\Models\Contact')
                    ->selectRaw('id, count(*) as aggregate')
                    ->whereNotNull('user_id')
                    ->groupBy('business_id');
    }

    /**
     * get SubscriptionsCount Attribute
     *
     * @return integer Count of Contacts with real User held by this Business
     */
    public function getSubscriptionsCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('subscriptionsCount', $this->relations)) {
            $this->load('subscriptionsCount');
        }

        $related = $this->getRelation('subscriptionsCount');

        // then return the count directly
        return ($related->count()>0) ? (int) $related->first()->aggregate : 0;
    }

    ///////////////
    // Overrides //
    ///////////////

    // 

    ///////////////
    // Presenter //
    ///////////////

    /**
     * Return a created presenter.
     *
     * @return Robbo\Presenter\Presenter
     */
    public function getPresenter()
    {
        return new BusinessPresenter($this);
    }

    //////////////
    // Mutators //
    //////////////

    /**
     * set Slug
     *
     * @return string      Generated slug
     */
    public function setSlugAttribute()
    {
        return $this->attributes['slug'] = str_slug($this->name);
    }

    /**
     * set name of the business
     *
     * @param string $name Name of business
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = trim($name);
        $this->setSlugAttribute();
    }

    /**
     * set Phone
     *
     * Expected phone number is international format numeric only
     *
     * @param string $phone Phone number
     */
    public function setPhoneAttribute($phone)
    {
        $this->attributes['phone'] = trim($phone) ?: null;
    }

    /**
     * set Postal Address
     *
     * @param string $postal_address Postal address
     */
    public function setPostalAddressAttribute($postalAddress)
    {
        $this->attributes['postal_address'] = trim($postalAddress) ?: null;
    }

    /**
     * set Social Facebook
     *
     * @param string $social_facebook Facebook User URL
     */
    public function setSocialFacebookAttribute($facebookPageUrl)
    {
        $this->attributes['social_facebook'] = trim($facebookPageUrl) ?: null;
    }
}
