<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model {

	# protected $table = 'businesses';

	protected $fillable = ['slug', 'name', 'description'];

	public function owners()
	{
		return $this->belongsToMany(config('auth.model'))->withTimestamps();
	}

}
