<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Presenters\AppointmentPresenter;

class Appointment extends Model implements \Robbo\Presenter\PresentableInterface
{
    protected $fillable = ['issuer_id', 'contact_id', 'business_id', 'service_id', 'start_at', 'duration', 'comments'];

    protected $guarded = ['id', 'hash', 'status', 'finish_at'];

    protected $dates = ['start_at', 'finish_at'];

    protected $widget = null;

    const STATUS_RESERVED  = 'R';
    const STATUS_CONFIRMED = 'C';
    const STATUS_ANNULATED = 'A';
    const STATUS_SERVED    = 'S';

    const PROFILE_USER    = 'user';
    const PROFILE_MANAGER = 'manager';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['hash'] = md5($this->start_at.'/'.$this->contact_id.'/'.$this->business_id.'/'.$this->service_id);
    }

    /**
     * Return a created presenter.
     *
     * @return Robbo\Presenter\Presenter
     */
    public function getPresenter()
    {
        return new AppointmentPresenter($this);
    }

    public function save(array $options = array())
    {
        parent::save();
    }

    public function issuer()
    {
        return $this->belongsTo('App\User');
    }

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    public function user()
    {
        return $this->contact->first()->user->first();
    }

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function duplicates()
    {
        return !self::where('hash', $this->hash)->get()->isEmpty();
    }

    public function getFinishAtAttribute()
    {
        if (is_numeric($this->duration)) {
            return $this->start_at->addMinutes($this->duration);
        }
        return $this->start_at;
    }

    public function getTZAttribute()
    {
        return $this->business->timezone;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [ Self::STATUS_RESERVED  => 'reserved',
                    Self::STATUS_CONFIRMED => 'confirmed',
                    Self::STATUS_ANNULATED => 'annulated',
                    Self::STATUS_SERVED    => 'served',
                ];

        return array_key_exists($this->status, $labels) ? $labels[$this->status] : '';
    }

    public function getDateAttribute()
    {
        return $this->start_at->timezone('UTC')->toDateString();
    }

    public function setStartAtAttribute(Carbon $datetime)
    {
        $this->attributes['start_at'] = $datetime;
    }

    public function setCommentsAttribute($comments)
    {
        $this->attributes['comments'] = $comments ?: null;
    }

    public function isActive()
    {
        return $this->status == Self::STATUS_CONFIRMED || $this->status == Self::STATUS_RESERVED;
    }

    public function isPending()
    {
        return $this->isActive() && $this->isFuture();
    }

    public function isFuture()
    {
        return !$this->isDue();
    }

    public function isDue()
    {
        return $this->start_at->isPast();
    }

    public function scopeUnServed($query)
    {
        return $query->where('status', '<>', Self::STATUS_SERVED);
    }

    public function scopeServed($query)
    {
        return $query->where('status', '=', Self::STATUS_SERVED);
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('start_at', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [Self::STATUS_RESERVED, Self::STATUS_CONFIRMED]);
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

    public function scopeFuture($query)
    {
        return $query->where('start_at', '>=', Carbon::parse('today midnight')->timezone('UTC'));
    }

    public function scopeTillDate($query, Carbon $date)
    {
        return $query->where('start_at', '<=', $date->timezone('UTC'));
    }

    public function doConfirm()
    {
        if ($this->isConfirmable()) {
            $this->status = self::STATUS_CONFIRMED;
            $this->save();
        }
    }

    public function doAnnulate()
    {
        if ($this->isAnnulable()) {
            $this->status = self::STATUS_ANNULATED;
            $this->save();
        }
    }

    public function doServe()
    {
        if ($this->isServeable()) {
            $this->status = self::STATUS_SERVED;
            $this->save();
        }
    }

    public function isServeable()
    {
        return ($this->status == self::STATUS_RESERVED || $this->status == self::STATUS_CONFIRMED) && $this->isDue();
    }

    public function isConfirmable()
    {
        return ($this->status == self::STATUS_RESERVED && $this->isFuture());
    }

    public function isAnnulable()
    {
        return ($this->status == self::STATUS_RESERVED || $this->status == self::STATUS_CONFIRMED);
    }

    public function needConfirmationOf($profile)
    {
        return ($this->issuer()->first() == $this->user() && $profile == self::PROFILE_USER) ||
               ($this->issuer()->first() != $this->user() && $profile == self::PROFILE_MANAGER);
    }
}
