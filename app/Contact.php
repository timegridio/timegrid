<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Business;

class Contact extends Model
{
    protected $fillable = ['firstname', 'lastname', 'nin', 'email', 'birthdate', 'mobile', 'mobile_country', 'notes', 'gender', 'occupation', 'martial_status', 'postal_address'];

    protected $dates = ['birthdate'];

    public function save(array $options = array())
    {
        $changed = $this->getDirty();

        if (array_key_exists('email', $changed)) {
            $this->linkToUser(true);
        }
        parent::save();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function business(Business $business)
    {
        return $this->belongsToMany('App\Business')->withPivot('notes')->where('business_id', $business->id)->withTimestamps()->first();
    }

    public function businesses()
    {
        return $this->belongsToMany('App\Business');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }

    public function appointment()
    {
        return $this->appointments->first();
    }

    public function hasAppointment()
    {
        return $this->appointmentsCount > 0;
    }

    public function appointmentsCount()
    {
        return $this->hasMany('App\Appointment')->selectRaw('contact_id, count(*) as aggregate')->groupBy('contact_id');
    }
     
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

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getUsernameAttribute()
    {
        return ($this->user) ? $this->user->email : null;
    }

    public function setMobileAttribute($mobile)
    {
        $this->attributes['mobile'] = trim($mobile) ?: null;
    }

    public function setMobileCountryAttribute($country)
    {
        $this->attributes['mobile_country'] = trim($country) ?: null;
    }

    public function setBirthdateAttribute($birthdate)
    {
        $this->attributes['birthdate'] = trim($birthdate) ? Carbon::parse($birthdate) : null;
    }

    public function getAgeAttribute($semantic = false)
    {
        $reference = new \DateTime;
        $born = new \DateTime($this->birthdate);

        if ($this->birthdate > $reference) {
            return '';
        }

        $diff = $reference->diff($born);

        if ($semantic) {
            $age = ($d = $diff->d) ? ' and '.$d.' '.str_plural('day', $d) : '';
            $age = ($m = $diff->m) ? ($age ? ', ' : ' and ').$m.' '.str_plural('month', $m).$age : $age;
            $age = ($y = $diff->y) ? $y.' '.str_plural('year', $y).$age  : $age;

            // trim redundant ',' or 'and' parts
            return ($s = trim(trim($age, ', '), ' and ')) ? $s.' old' : 'newborn';
        } else {
            return $diff->y;
        }
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = trim($email) ?: null;
    }

    public function setNinAttribute($nin)
    {
        $this->attributes['nin'] = trim($nin) ?: null;
    }

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

    public function unlinkUser()
    {
        $this->attributes['user_id'] = null;

        return $this;
    }

    public function isSuscribedTo(Business $business)
    {
        return $this->businesses->contains($business);
    }

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
