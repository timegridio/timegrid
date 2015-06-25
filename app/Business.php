<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];
	# protected $table = 'businesses';

	protected $fillable = ['slug', 'name', 'description'];

	public function owners()
	{
		return $this->belongsToMany(config('auth.model'))->withTimestamps();
	}

	public function owner()
	{
		return $this->belongsToMany(config('auth.model'))->withTimestamps()->first();
	}

	public function contacts()
	{
		return $this->belongsToMany('App\Contact');
	}

}
