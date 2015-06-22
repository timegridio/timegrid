<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $fillable = ['firstname', 'lastname', 'nin', 'birthdate', 'mobile', 'notes', 'gender'];

	public function businesses()
	{
		return $this->belongsToMany('App\Business');
	}
}
