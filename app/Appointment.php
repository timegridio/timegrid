<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {

	protected $fillable = ['contact_id', 'business_id', 'date', 'time', 'duration', 'comments'];

	public function contact()
	{
		return $this->belongsTo('\App\Contact');
	}

}
