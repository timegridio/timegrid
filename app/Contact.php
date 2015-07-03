<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        return ($this->user !== null) ? $this->user->email : null;
    }

    public function setMobileAttribute($mobile)
    {
        $this->attributes['mobile'] = trim($mobile) !== '' ? $mobile : null;
    }

    public function setMobileCountryAttribute($country)
    {
        $this->attributes['mobile_country'] = trim($country) !== '' ? $country : null;
    }

    public function setBirthdateAttribute($birthdate)
    {
        $this->attributes['birthdate'] = $birthdate == '' ? null : Carbon::parse($birthdate);
    }

    public function getAgeAttribute($semantic = false)
    {
        $reference = new \DateTime;
        $born = new \DateTime($this->birthdate);
        # dd($this->birthdate);
        if ($this->birthdate > $reference) {
            # Log::warning('Invalid birthdate: ');
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
        if (trim($email) == '') {
            $this->attributes['email'] = null;
        }
        $this->attributes['email'] = $email;
    }

    public function linkToUser($force_relink = false)
    {
        if ($this->user_id !== null && $force_relink == false) {
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

    public function isSuscribedTo(\App\Business $business)
    {
        return $this->businesses->contains($business);
    }

#	public function getSuscriptionsAttribute()
#	{
#		$suscriptions = [];
#		foreach ($this->businesses as $business) {
#			$suscriptions[] = $business->slug;
#		}
#		return implode(',', $suscriptions);
#	}
}
