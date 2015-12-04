<?php

namespace App\Models;

use Carbon\Carbon;
use App\Presenters\AppointmentPresenter;
use Robbo\Presenter\PresentableInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Appointment extends EloquentModel implements PresentableInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['issuer_id', 'contact_id', 'business_id', 'service_id', 'start_at', 'duration', 'comments'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'hash', 'status', 'finish_at', 'vacancy_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_at', 'finish_at'];

    /**
     * Appointment Hard Status Constants
     */
    const STATUS_RESERVED = 'R';
    const STATUS_CONFIRMED = 'C';
    const STATUS_ANNULATED = 'A';
    const STATUS_SERVED = 'S';

    /**
     * User Profile Constants
     *
     * Used to determine the detected behavior of the user depending
     * on if he acts as a user or a Business manager.
     */
    const PROFILE_USER = 'user';
    const PROFILE_MANAGER = 'manager';

    /**
     * Return a created presenter.
     *
     * @return Robbo\Presenter\Presenter
     */
    public function getPresenter()
    {
        return new AppointmentPresenter($this);
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $this->doHash();
        return parent::save($options);
    }

    ///////////////////
    // Relationships //
    ///////////////////

    /**
     * Issuer
     *
     * @return Collection $user User who has created the appointment
     */
    public function issuer()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Contact
     *
     * @return Collection $contact Contact for whom the appointment is made
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }

    /**
     * Business
     *
     * @return Collection $business Business for which the appointment is made
     */
    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    /**
     * Service
     *
     * @return Collection $service Service for which the contact is set for appointment
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    /**
     * Vacancy
     *
     * @return Collection $vacancy Vacancy that holds the appointment
     */
    public function vacancy()
    {
        return $this->belongsTo('App\Models\Vacancy');
    }

    ///////////
    // Other //
    ///////////

    /**
     * User
     *
     * @return [type] [description]
     */
    public function user()
    {
        return $this->contact->user;
    }

    /**
     * Duplicates
     *
     * @return boolean Determines if the new Appointment will hash crash with an existing Appointment
     */
    public function duplicates()
    {
        return !self::where('hash', $this->hash)->get()->isEmpty();
    }

    ///////////////
    // Accessors //
    ///////////////

    public function getHashAttribute()
    {
        return isset($this->attributes['hash']) ? $this->attributes['hash'] : $this->doHash();
    }

    /**
     * FinishAt
     *
     * @return Carbon Calculates the start_at time plus duration in minutes
     */
    public function getFinishAtAttribute()
    {
        if (is_numeric($this->duration)) {
            return $this->start_at->addMinutes($this->duration);
        }
        return $this->start_at;
    }

    /**
     * TimeZone
     *
     * @return string The TimeZone set for Business
     */
    public function getTZAttribute()
    {
        return $this->business->timezone;
    }

    /**
     * Get the human readable status name
     *
     * @return string The name of the current Appointment status
     */
    public function getStatusLabelAttribute()
    {
        $labels = [ Self::STATUS_RESERVED  => 'reserved',
                    Self::STATUS_CONFIRMED => 'confirmed',
                    Self::STATUS_ANNULATED => 'annulated',
                    Self::STATUS_SERVED    => 'served',
                ];

        return array_key_exists($this->status, $labels) ? $labels[$this->status] : '';
    }

    /**
     * Date
     *
     * @return string Formatted Date string from the start_at attribute in UTC
     */
    public function getDateAttribute()
    {
        return $this->start_at->timezone('UTC')->toDateString();
    }

    //////////////
    // Mutators //
    //////////////

    /**
     * do Hash
     *
     * @return string MD5 hash for unique id
     */
    public function doHash()
    {
        return $this->attributes['hash'] = md5($this->start_at . '/' .
                                                $this->contact_id .'/' .
                                                $this->business_id .'/'.
                                                $this->service_id);
    }

    /**
     * Set start_at attribute
     *
     * @param Carbon $datetime The Appointment starting datetime
     */
    public function setStartAtAttribute(Carbon $datetime)
    {
        $this->attributes['start_at'] = $datetime;
    }

    /**
     * Set Comments
     *
     * @param string $comments User comments for the Business owner on the Appointment
     */
    public function setCommentsAttribute($comments)
    {
        $this->attributes['comments'] = trim($comments) ?: null;
    }

    ///////////////////////////
    // Calculated attributes //
    ///////////////////////////

    /**
     * Appointment Status Workflow
     *
     * Hard Status: Those concrete values stored in DB
     * Soft Status: Those values calculated from stored values in DB
     *
     * Suggested transitions (Binding is not mandatory)
     *     Reserved -> Confirmed -> Served
     *     Reserved -> Served
     *     Reserved -> Annulated
     *     Reserved -> Confirmed -> Annulated
     *
     * Soft Status
     *     (Active)   [ Reserved  | Confirmed ]
     *     (InActive) [ Annulated | Served    ]
     *
     */

    /**
     * is Active
     *
     * @return boolean Determination if the Appointment is in an active status
     */
    public function isActive()
    {
        return $this->status == Self::STATUS_CONFIRMED || $this->status == Self::STATUS_RESERVED;
    }

    /**
     * is Pending
     *
     * @return boolean is Active AND is Future
     */
    public function isPending()
    {
        return $this->isActive() && $this->isFuture();
    }

    /**
     * is Future
     *
     * @return boolean The start_at datetime is future from the current system datetime
     */
    public function isFuture()
    {
        return !$this->isDue();
    }

    /**
     * is Due
     *
     * @return boolean The start_at datetime is past from the current system datetime
     */
    public function isDue()
    {
        return $this->start_at->isPast();
    }

    ////////////
    // Scopes //
    ////////////

    /////////////////////////
    // Hard Status Scoping //
    /////////////////////////

    /**
     * Scope to Unarchived Appointments
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeUnarchived($query)
    {
        return $query
            ->where(function ($query) {
                $query->whereIn('status', [Self::STATUS_RESERVED, Self::STATUS_CONFIRMED])
                    ->where('start_at', '<=', Carbon::parse('today midnight')->timezone('UTC'));
            })
            ->orWhere(function ($query) {
                $query->where('start_at', '>=', Carbon::parse('today midnight')->timezone('UTC'));
            });
    }

    /**
     * Scope to Served Appointments
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeServed($query)
    {
        return $query->where('status', '=', Self::STATUS_SERVED);
    }

    /**
     * Scope to Annulated Appointments
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeAnnulated($query)
    {
        return $query->where('status', '=', Self::STATUS_ANNULATED);
    }

    /////////////////////////
    // Soft Status Scoping //
    /////////////////////////

    /**
     * Scope to not Served Appointments
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeUnServed($query)
    {
        return $query->where('status', '<>', Self::STATUS_SERVED);
    }

    /**
     * Scope to Active Appointments
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [Self::STATUS_RESERVED, Self::STATUS_CONFIRMED]);
    }
    
    /////////////
    // Sorting //
    /////////////

    /**
     * Oldest first
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('start_at', 'ASC');
    }

    /**
     * Of Business
     *
     * @param  Illuminate\Database\Query   $query
     * @param  Business $business An inquired business to validate against
     * @return Illuminate\Database\Query The appointments belonging to the inquired Business as holder
     */
    public function scopeOfBusiness($query, Business $business)
    {
        return $query->where('business_id', '=', $business->id);
    }

    /**
     * Of Date
     *
     * @param  Illuminate\Database\Query $query
     * @param  Carbon $date  An inquired date to validate against
     * @return Illuminate\Database\Query    The scoped appointments for the inquired date
     */
    public function scopeOfDate($query, Carbon $date)
    {
        return $query->whereRaw('date(`start_at`) = ?', [$date->timezone('UTC')->toDateString()]);
    }

    /**
     * Scope only future appointments
     *
     * @param  Illuminate\Database\Query $query
     * @return Illuminate\Database\Query The appointments scoped for future date
     */
    public function scopeFuture($query)
    {
        return $query->where('start_at', '>=', Carbon::parse('today midnight')->timezone('UTC'));
    }

    /**
     * Scope only till date
     *
     * @param  Illuminate\Database\Query $query
     * @param  Carbon $date  Inquired range end date
     * @return Illuminate\Database\Query Scoped appointments up to the inquired date
     */
    public function scopeTillDate($query, Carbon $date)
    {
        return $query->where('start_at', '<=', $date->timezone('UTC'));
    }

    //////////////////////////
    // Soft Status Checkers //
    //////////////////////////

    /**
     * is Serveable
     *
     * @return boolean The Serve action can be performed
     */
    public function isServeable()
    {
        return ($this->status == self::STATUS_RESERVED || $this->status == self::STATUS_CONFIRMED) && $this->isDue();
    }

    /**
     * is Confirmable
     *
     * @return boolean The Confirm action can be performed
     */
    public function isConfirmable()
    {
        return ($this->status == self::STATUS_RESERVED && $this->isFuture());
    }

    /**
     * is Annulable
     *
     * @return boolean The Annulate action can be performed
     */
    public function isAnnulable()
    {
        return ($this->status == self::STATUS_RESERVED || $this->status == self::STATUS_CONFIRMED);
    }

    /////////////////////////
    // Hard Status Actions //
    /////////////////////////

    /**
     * Check and perform Confirm action
     *
     * @return Appointment The changed Appointment
     */
    public function doReserve()
    {
        if ($this->status === null) {
            $this->status = self::STATUS_RESERVED;
        }
        return $this;
    }

    /**
     * Check and perform Confirm action
     *
     * @return Appointment The changed Appointment
     */
    public function doConfirm()
    {
        if ($this->isConfirmable()) {
            $this->status = self::STATUS_CONFIRMED;
            return $this->save();
        }
        return $this;
    }

    /**
     * Check and perform Annulate action
     *
     * @return Appointment The changed Appointment
     */
    public function doAnnulate()
    {
        if ($this->isAnnulable()) {
            $this->status = self::STATUS_ANNULATED;
            return $this->save();
        }
        return $this;
    }

    /**
     * Check and perform Serve action
     *
     * @return Appointment The changed Appointment
     */
    public function doServe()
    {
        if ($this->isServeable()) {
            $this->status = self::STATUS_SERVED;
            return $this->save();
        }
        return $this;
    }

    /**
     * Need confirmation of
     *
     * @param  string $profile Name of the current User profile [user|manager]
     * @return boolean         The Appointment needs to be confirmed by the inquired User profile
     */
    public function needConfirmationOf($profile)
    {
        return ($this->issuer()->first() != $this->user() && $profile == self::PROFILE_USER) ||
               ($this->issuer()->first() == $this->user() && $profile == self::PROFILE_MANAGER);
    }
}
