<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $fillable = ['firstname', 'lastname', 'nin', 'birthdate', 'mobile', 'notes', 'gender'];

	public function businesses()
	{
		return $this->belongsToMany('App\Business');
	}

	public function age($semantic = false)
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
