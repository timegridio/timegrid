<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fenos\Notifynder\Notifable;

class Business extends Model
{
    use SoftDeletes;
    use Notifable;
    use Traits\Preferenceable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name', 'description', 'timezone', 'postal_address', 'phone', 'social_facebook', 'strategy', 'plan'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
        return $this->belongsTo('App\Category')->remember(120);
    }

    /**
     * holds Contacts
     * 
     * @return Illuminate\Database\Query Relationship Business held Contacts query
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Contact')->with('user')->withPivot('notes')->withTimestamps();
    }

    /**
     * provides Services
     * 
     * @return Illuminate\Database\Query Relationship Business provided Services query
     */
    public function services()
    {
        return $this->hasMany('App\Service');
    }

    /**
     * publishes Vacancies
     * 
     * @return Illuminate\Database\Query Relationship Business published Vacancies query
     */
    public function vacancies()
    {
        return $this->hasMany('App\Vacancy');
    }

    /**
     * holds Appointments booking
     * 
     * @return Illuminate\Database\Query Relationship Business holds Appointments query
     */
    public function bookings()
    {
        return $this->hasMany('App\Appointment');
    }

    /**
     * belongs to Users
     * 
     * @return Illuminate\Database\Query Relationship Business belongs to User (owners) query
     */
    public function owners()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps()->remember(120);
    }

    /**
     * belongs to User
     * 
     * @return App\User Relationship Business belongs to User (owner)
     */
    public function owner()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps()->remember(120)->first();
    }

    /**
     * Get the real Users suscriptions count
     * 
     * @return Illuminate\Database\Query Relationship
     */
    public function suscriptionsCount()
    {
        return $this->belongsToMany('App\Contact')->selectRaw('id, count(*) as aggregate')->whereNotNull('user_id')->groupBy('business_id');
    }

    /**
     * get SuscriptionsCount Attribute
     *
     * @return integer Count of Contacts with real User held by this Business
     */
    public function getSuscriptionsCountAttribute()
    {
        // if relation is not loaded already, let's do it first
        if (! array_key_exists('suscriptionsCount', $this->relations)) {
            $this->load('suscriptionsCount');
        }

        $related = $this->getRelation('suscriptionsCount');

        // then return the count directly
        return ($related->count()>0) ? (int) $related->first()->aggregate : 0;
    }

    //////////////
    // Mutators //
    //////////////

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
    public function setPostalAddressAttribute($postal_address)
    {
        $this->attributes['postal_address'] = trim($postal_address) ?: null;
    }

    /**
     * TODO: Move to Presenter
     * 
     * get Google Static Map img
     * 
     * @param  integer $zoom Zoom Level
     * @return string        HTML code to render img with map
     */
    public function staticMap($zoom = 15)
    {
        $data = array('center'         => $this->postal_address,
                      'zoom'           => intval($zoom),
                      'scale'          =>'2',
                      'size'           =>'180x100',
                      'maptype'        =>'roadmap',
                      'format'         =>'gif',
                      'visual_refresh' =>'true');

        $src = 'http://maps.googleapis.com/maps/api/staticmap?' . http_build_query($data, '', '&amp;');
        return "<img calss=\"img-responsive img-thumbnail center-block\" src=\"$src\"/>";
    }

    /**
     * TODO: Move to Presenter
     * 
     * get Facebook Profile Public Picture
     * 
     * @param  string $type Type of picture to print
     * @return string       HTML code to render img with facebook picture
     */
    public function facebookPicture($type = 'normal')
    {
        $src = "https://graph.facebook.com/{$this->social_facebook}/picture?type=$type";
        return $this->social_facebook ? "<img calss=\"img-thumbnail media-object\" src=\"$src\"/>" : "<img calss=\"img-thumbnail media-object\" src=\"//placehold.it/100x100\"/>";
    }
}
