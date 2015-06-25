<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Appointment extends Model {

	protected $fillable = ['contact_id', 'business_id', 'date', 'time', 'duration', 'comments'];

	const STATUS_RESERVED  = 'R';
	const STATUS_CONFIRMED = 'C';
	const STATUS_ANNULATED = 'A';
	const STATUS_SERVED    = 'S';

	public function contact()
	{
		return $this->belongsTo('\App\Contact');
	}

	public function getFinishTimeAttribute()
	{
		if (is_numeric($this->duration)) {
			$carbon = new Carbon("{$this->date} {$this->time}");
			return $carbon->addMinutes($this->duration);
		}
	}

	public function getStatusLabelAttribute()
	{
		switch ($this->status) {
			case Self::STATUS_RESERVED:
				$label = trans('appointments.status.reserved');
				break;
			case Self::STATUS_CONFIRMED:
				$label = trans('appointments.status.confirmed');
				break;
			case Self::STATUS_ANNULATED:
				$label = trans('appointments.status.annulated');
				break;
			case Self::STATUS_SERVED:
				$label = trans('appointments.status.annulated');
				break;
			default:
				$label = '?';
				break;
		}
		return $label;
	}

}
