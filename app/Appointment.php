<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = ['contact_id', 'business_id', 'service_id', 'start_at', 'duration', 'comments'];

    protected $guarded = ['id', 'hash', 'status', 'finish_at'];

    protected $dates = ['start_at', 'finish_at'];

    const STATUS_RESERVED  = 'R';
    const STATUS_CONFIRMED = 'C';
    const STATUS_ANNULATED = 'A';
    const STATUS_SERVED    = 'S';

    public function save(array $options = array())
    {
        $this->attributes['hash'] = md5($this->start_at.$this->contact_id.$this->business_id.$this->service_id);

        parent::save();
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function getFinishAtAttribute()
    {
        if (is_numeric($this->duration)) {
            return $this->start_at->addMinutes($this->duration);
        }
        return $this->start_at;
    }

    public function getCodeAttribute()
    {
        return strtoupper(substr($this->hash, 0, 6));
    }

    public function getTZAttribute()
    {
        return $this->business->timezone;
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

    public function getDateAttribute()
    {
        return $this->start_at->timezone('UTC')->toDateString();
    }

    public function setStartAtAttribute($datetime)
    {
        $this->attributes['start_at'] = Carbon::parse($datetime, $this->tz)->timezone('UTC');
    }

    public function scopeServed($query)
    {
        return $query->where('status', '=', Self::STATUS_SERVED);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', Self::STATUS_RESERVED)->orWhere('status', '=', Self::STATUS_CONFIRMED);
    }

    public function scopeAnnulated($query)
    {
        return $query->where('status', '=', Self::STATUS_ANNULATED);
    }

    public function scopeOfBusiness($query, Business $business)
    {
        return $query->where('business_id', '=', $business->id);
    }

    public function scopeOfDate($query, Carbon $date)
    {
        return $query->whereRaw('date(`start_at`) = ?', [$date->timezone('UTC')->toDateString()]);
    }

    public function scopeFuture($query, $tillDate = false)
    {
        return $query->where('start_at', '>=', Carbon::parse('today midnight')->timezone('UTC'));
    }

    public function scopeTillDate($query, Carbon $date)
    {
        return $query->where('start_at', '<=', $date->timezone('UTC'));
    }

    public function doAnnulate()
    {
        if ($this->status == self::STATUS_RESERVED) {
            $this->status = self::STATUS_ANNULATED;
            $this->save();
        }
    }

    public function doServe()
    {
        if ($this->status == self::STATUS_CONFIRMED) {
            $this->status = self::STATUS_SERVED;
            $this->save();
        }
    }
}
