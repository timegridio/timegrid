<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $fillable = ['firstname', 'lastname', 'nin', 'birthdate', 'mobile', 'mobile_country', 'notes', 'gender'];

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
	  if ( ! array_key_exists('appointmentsCount', $this->relations)) $this->load('appointmentsCount');
	 
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

	public function getAgeAttribute($semantic = false)
	{
	    $reference = new \DateTime;
	    $born = new \DateTime($this->birthdate);
	
	    if ($this->birthdate > $reference) 
	        throw new \InvalidArgumentException('Provided birthday cannot be in future compared to the reference date.');
	
	    $diff = $reference->diff($born);
	
	    if ($semantic) {
		    $age = ($d = $diff->d) ? ' and '.$d.' '.str_plural('day', $d) : '';
		    $age = ($m = $diff->m) ? ($age ? ', ' : ' and ').$m.' '.str_plural('month', $m).$age : $age;
		    $age = ($y = $diff->y) ? $y.' '.str_plural('year', $y).$age  : $age;
	    	
	    	// trim redundant ',' or 'and' parts
	    	return ($s = trim(trim($age, ', '), ' and ')) ? $s.' old' : 'newborn';
	    }
	    else
	    {
	    	return $diff->y;
	    }
	}

}
