<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model {

	protected $fillable = ['contact_id', 'business_id', 'date', 'time', 'duration', 'comments'];

	protected $guarded = ['id', 'hash', 'status'];

	const STATUS_RESERVED  = 'R';
	const STATUS_CONFIRMED = 'C';
	const STATUS_ANNULATED = 'A';
	const STATUS_SERVED    = 'S';

	public function save(array $options = array())
	{
		$this->attributes['hash'] = md5($this->attributes['date'].$this->attributes['time'].$this->attributes['contact_id']);

		parent::save();
	}

	public function contact()
	{
		return $this->belongsTo('\App\Contact');
	}

	public function business()
	{
		return $this->belongsTo('\App\Business');
	}

	public function getFinishTimeAttribute()
	{
		if (is_numeric($this->duration)) {
			$carbon = Carbon::parse($this->date . ' ' .$this->time)->timezone($this->tz);
			return $carbon->addMinutes($this->duration)->toTimeString();
		}
	}

	public function getCodeAttribute()
	{
		return strtoupper(substr($this->hash, 0, 6));
	}

	public function getTZAttribute()
	{
		return $this->business->timezone;
		/* Doesent seem to improve performance */
		# if (!array_key_exists('timezone', $this->attributes)) {
		#  	$this->attributes['timezone'] = $this->business->timezone;
		# }
		# return $this->attributes['timezone'];
	}

	public function getStatusLabelAttribute()
	{
		switch ($this->status) {
			case Self::STATUS_RESERVED:  $label = 'reserved';
				break;
			case Self::STATUS_CONFIRMED: $label = 'confirmed';
				break;
			case Self::STATUS_ANNULATED: $label = 'annulated';
				break;
			case Self::STATUS_SERVED:    $label = 'served';
				break;
			default: $label = '?';
				break;
		}
		return $label;
	}

	public function getTZTimeAttribute()
	{
		return Carbon::parse($this->time)->timezone($this->tz)->toTimeString();
	}

	public function getTZDateAttribute()
	{
		return Carbon::parse($this->date . ' ' . $this->time)->timezone($this->tz)->toDateString();
	}
}
