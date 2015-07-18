<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['slug', 'name', 'description', 'timezone', 'postal_address', 'phone', 'social_facebook', 'strategy'];

    public function owners()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps();
    }

    // public function owner()
    // {
        // return $this->belongsToMany(config('auth.model'))->withTimestamps()->first();
    // }

    public function owner()
    {
        return $this->belongsToMany('App\User')->withTimestamps()->first();
    }

    public function contacts()
    {
        return $this->belongsToMany('App\Contact')->with('user')->withPivot('notes')->withTimestamps();
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function vacancies()
    {
        return $this->hasMany('App\Vacancy');
    }

    public function bookings()
    {
        return $this->hasMany('App\Appointment');
    }

    // public function setPostalAddressAttribute($string)
    // {
    //     preg_match_all('/(?<street>[\w\d\ ]+)(\,(?<city>[\w\d\ ]+))?(\,(?<country>[\w\d\ ]+))?/', $string, $matches);
    //     $this->attributes['postal_address'] = json_encode($matches);
    // }

    // public function getPostalAddressAttribute()
    // {
    //     if(empty(trim($this->attributes['postal_address']))) return [];
    //     $address = json_decode($this->attributes['postal_address']);
    //     return $address->street[0] . ', ' . $address->city[0] . ', ' . $address->country[0];
    // }

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

    public function facebookPicture($type = 'normal')
    {
        $src = "https://graph.facebook.com/{$this->social_facebook}/picture?type=$type";
        return "<img calss=\"img-thumbnail media-object\" src=\"$src\"/>";
    }
    
}
