<?php

namespace App\Models;

use App\Presenters\AppointmentPresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * An Appointment can be understood as a reservation of a given Service,
 * provided by a given Business, targeted to a Contact, which will take place
 * on a determined Date and Time, and might have a duration and or comments.
 *
 * The Appointment can be issued by the Contact's User or by the Business owner.
 */
class Appointment extends EloquentModel implements HasPresenter
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['issuer_id', 'contact_id', 'business_id',
        'service_id', 'start_at', 'finish_at', 'duration', 'comments', ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'hash', 'status', 'vacancy_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_at', 'finish_at'];

    /**
     * Appointment Hard Status Constants.
     */
    const STATUS_RESERVED = 'R';
    const STATUS_CONFIRMED = 'C';
    const STATUS_ANNULATED = 'A';
    const STATUS_SERVED = 'S';

    ///////////////
    // PRESENTER //
    ///////////////

    /**
     * Get Presenter Class.
     *
     * @return App\Presenters\AppointmentPresenter
     */
    public function getPresenterClass()
    {
        return AppointmentPresenter::class;
    }

    /**
     * Generate hash and save the model to the database.
     *
     * @param array $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->doHash();

        return parent::save($options);
    }

    ///////////////////
    // Relationships //
    ///////////////////

    /**
     * Get the issuer (the User that generated the Appointment).
     *
     * @return App\Models\User
     */
    public function issuer()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the target Contact (for whom is reserved the Appointment).
     *
     * @return App\Models\Contact
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }

    /**
     * Get the holding Business (that has taken the reservation).
     *
     * @return App\Models\Business
     */
    public function business()
    {
        return $this->belongsTo('App\Models\Business');
    }

    /**
     * Get the reserved Service.
     *
     * @return App\Models\Service
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    /**
     * Get the Vacancy (that justifies the availability of resources for the
     * Appointment generation).
     *
     * @return App\Models\Vacancy
     */
    public function vacancy()
    {
        return $this->belongsTo('App\Models\Vacancy');
    }

    ///////////
    // Other //
    ///////////

    /**
     * Get the User through Contact.
     *
     * @return App\Models\User
     */
    public function user()
    {
        return $this->contact->user;
    }

    /**
     * Determine if the new Appointment will hash-crash with another existing
     * Appointment.
     *
     * @return bool
     */
    public function duplicates()
    {
        return !self::where('hash', $this->hash)->get()->isEmpty();
    }

    ///////////////
    // Accessors //
    ///////////////

    /**
     * Get Hash.
     *
     * @return string
     */
    public function getHashAttribute()
    {
        return isset($this->attributes['hash'])
            ? $this->attributes['hash']
            : $this->doHash();
    }

    /**
     * Get Finish At:
     * Calculates the start_at time plus duration in minutes.
     *
     * @return Carbon
     */
    public function getFinishAtAttribute()
    {
        if (array_get($this->attributes, 'finish_at') !== null) {
            return Carbon::parse($this->attributes['finish_at']);
        }

        if (is_numeric($this->duration)) {
            return $this->start_at->addMinutes($this->duration);
        }

        return $this->start_at;
    }

    /**
     * Get TimeZone (from the Business).
     *
     * @return string
     */
    public function getTZAttribute()
    {
        return $this->business->timezone;
    }

    /**
     * Get annulation deadline (target date).
     *
     * @return Carbon\Carbon
     */
    public function getAnnulationDeadlineAttribute()
    {
        $hours = $this->business->pref('appointment_annulation_pre_hs');

        return $this->start_at
                    ->subHours($hours)
                    ->timezone($this->business->timezone);
    }

    /**
     * Get the human readable status name.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            Self::STATUS_RESERVED  => 'reserved',
            Self::STATUS_CONFIRMED => 'confirmed',
            Self::STATUS_ANNULATED => 'annulated',
            Self::STATUS_SERVED    => 'served',
            ];

        return array_key_exists($this->status, $labels)
            ? $labels[$this->status]
            : '';
    }

    /**
     * Get the date of the Appointment.
     *
     * @return string
     */
    public function getDateAttribute()
    {
        return $this->start_at
                    ->timezone($this->business->timezone)
                    ->toDateString();
    }

    /**
     * Get user-friendly unique identification code.
     *
     * @return string
     */
    public function getCodeAttribute()
    {
        $length = $this->business->pref('appointment_code_length');

        return strtoupper(substr($this->hash, 0, $length));
    }

    //////////////
    // Mutators //
    //////////////

    /**
     * Generate Appointment hash.
     *
     * @return string
     */
    public function doHash()
    {
        return $this->attributes['hash'] = md5(
            $this->start_at.'/'.
            $this->contact_id.'/'.
            $this->business_id.'/'.
            $this->service_id
        );
    }

    /**
     * Set start at.
     *
     * @param Carbon $datetime
     */
    public function setStartAtAttribute(Carbon $datetime)
    {
        $this->attributes['start_at'] = $datetime;
    }

    /**
     * Set finish_at attribute.
     *
     * @param Carbon $datetime
     */
    public function setFinishAtAttribute(Carbon $datetime)
    {
        $this->attributes['finish_at'] = $datetime;
    }

    /**
     * Set Comments.
     *
     * @param string $comments
     */
    public function setCommentsAttribute($comments)
    {
        $this->attributes['comments'] = trim($comments) ?: null;
    }

    /////////////////
    // HARD STATUS //
    /////////////////

    /**
     * Determine if is Reserved.
     *
     * @return bool
     */
    public function isReserved()
    {
        return $this->status == Self::STATUS_RESERVED;
    }

    ///////////////////////////
    // Calculated attributes //
    ///////////////////////////

    /**
     * Appointment Status Workflow.
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
     */

    /**
     * Determine if is Active.
     *
     * @return bool
     */
    public function isActive()
    {
        return
            $this->status == Self::STATUS_CONFIRMED ||
            $this->status == Self::STATUS_RESERVED;
    }

    /**
     * Determine if is Pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->isActive() && $this->isFuture();
    }

    /**
     * Determine if is Future.
     *
     * @return bool
     */
    public function isFuture()
    {
        return !$this->isDue();
    }

    /**
     * Determine if is due.
     *
     * @return bool
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
     * Scope to Contacts Collection.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeForContacts($query, $contacts)
    {
        return $query->whereIn('contact_id', $contacts->lists('id'));
    }

    /**
     * Scope to Unarchived Appointments.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeUnarchived($query)
    {
        $todayMidnight = Carbon::parse('today midnight')->timezone('UTC');

        return $query
            ->where(function ($query) {
                $query->whereIn('status', [Self::STATUS_RESERVED, Self::STATUS_CONFIRMED])
                    ->where('start_at', '<=', $todayMidnight)
                    ->orWhere(function ($query) {
                        $query->where('start_at', '>=', $todayMidnight);
                    });
            });
    }

    /**
     * Scope to Served Appointments.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeServed($query)
    {
        return $query->where('status', '=', Self::STATUS_SERVED);
    }

    /**
     * Scope to Annulated Appointments.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeAnnulated($query)
    {
        return $query->where('status', '=', Self::STATUS_ANNULATED);
    }

    /////////////////////////
    // Soft Status Scoping //
    /////////////////////////

    /**
     * Scope to not Served Appointments.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeUnServed($query)
    {
        return $query->where('status', '<>', Self::STATUS_SERVED);
    }

    /**
     * Scope to Active Appointments.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [Self::STATUS_RESERVED, Self::STATUS_CONFIRMED]);
    }

    /**
     * Scope of Business.
     *
     * @param Illuminate\Database\Query $query
     * @param int                       $businessId
     *
     * @return Illuminate\Database\Query
     */
    public function scopeOfBusiness($query, $businessId)
    {
        return $query->where('business_id', '=', $businessId);
    }

    /**
     * Scope of date.
     *
     * @param Illuminate\Database\Query $query
     * @param Carbon                    $date
     *
     * @return Illuminate\Database\Query
     */
    public function scopeOfDate($query, Carbon $date)
    {
        return $query->whereRaw('date(`start_at`) = ?', [$date->timezone('UTC')->toDateString()]);
    }

    /**
     * Scope only future appointments.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeFuture($query)
    {
        $todayMidnight = Carbon::parse('today midnight')->timezone('UTC');

        return $query->where('start_at', '>=', $todayMidnight);
    }

    /**
     * Scope only till date.
     *
     * @param Illuminate\Database\Query $query
     * @param Carbon                    $date
     *
     * @return Illuminate\Database\Query
     */
    public function scopeTillDate($query, Carbon $date)
    {
        return $query->where('start_at', '<=', $date->timezone('UTC'));
    }

    /**
     * Between Dates.
     *
     * @param Illuminate\Database\Query $query
     * @param Carbon                    $startAt
     * @param Carbon                    $finishAt
     *
     * @return Illuminate\Database\Query
     */
    public function scopeAffectingInterval($query, Carbon $startAt, Carbon $finishAt)
    {
        return $query
            ->where(function ($query) use ($startAt, $finishAt) {

                $query->where(function ($query) use ($startAt, $finishAt) {
                    $query->where('finish_at', '>=', $finishAt->timezone('UTC'))
                          ->where('start_at', '<=', $startAt->timezone('UTC'));
                })
                ->orWhere(function ($query) use ($startAt, $finishAt) {
                    $query->where('finish_at', '<', $finishAt->timezone('UTC'))
                          ->where('finish_at', '>', $startAt->timezone('UTC'));
                })
                ->orWhere(function ($query) use ($startAt, $finishAt) {
                    $query->where('start_at', '>', $startAt->timezone('UTC'))
                          ->where('start_at', '<', $finishAt->timezone('UTC'));
                })
                ->orWhere(function ($query) use ($startAt, $finishAt) {
                    $query->where('start_at', '>', $startAt->timezone('UTC'))
                          ->where('finish_at', '<', $finishAt->timezone('UTC'));
                });

            });
    }

    /////////////
    // Sorting //
    /////////////

    /**
     * Sort oldest first.
     *
     * @param Illuminate\Database\Query $query
     *
     * @return Illuminate\Database\Query
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('start_at', 'ASC');
    }

    //////////////////////////
    // Soft Status Checkers //
    //////////////////////////

    /**
     * User is target contact of the appointment.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isTarget($userId)
    {
        return $this->contact->isProfileOf($userId);
    }

    /**
     * User is issuer of the appointment.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isIssuer($userId)
    {
        return $this->issuer->id == $userId;
    }

    /**
     * User is owner of business.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isOwner($userId)
    {
        return $this->business->owners->contains($userId);
    }

    /**
     * can be annulated by user.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function canAnnulate($userId)
    {
        return $this->isOwner($userId) ||
            ($this->isIssuer($userId) && $this->isOnTimeToAnnulate()) ||
            ($this->isTarget($userId) && $this->isOnTimeToAnnulate());
    }

    /**
     * Determine if it is still possible to annulate according business policy.
     *
     * @return bool
     */
    public function isOnTimeToAnnulate()
    {
        $graceHours = $this->business->pref('appointment_annulation_pre_hs');

        $diff = $this->start_at->diffInHours(Carbon::now());

        return intval($diff) >= intval($graceHours);
    }

    /**
     * can Serve.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function canServe($userId)
    {
        return $this->isOwner($userId);
    }

    /**
     * can confirm.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function canConfirm($userId)
    {
        return $this->isIssuer($userId) || $this->isOwner($userId);
    }

    /**
     * is Serveable by user.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isServeableBy($userId)
    {
        return $this->isServeable() && $this->canServe($userId);
    }

    /**
     * is Confirmable By user.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isConfirmableBy($userId)
    {
        return
            $this->isConfirmable() &&
            $this->shouldConfirmBy($userId) &&
            $this->canConfirm($userId);
    }

    /**
     * is Annulable By user.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isAnnulableBy($userId)
    {
        return $this->isAnnulable() && $this->canAnnulate($userId);
    }

    /**
     * Determine if the queried userId may confirm the appointment or not.
     *
     * @param int $userId
     *
     * @return bool
     */
    public function shouldConfirmBy($userId)
    {
        return ($this->isSelfIssued() && $this->isOwner($userId)) ||
               ($this->isOwner($this->issuer->id) && $this->isIssuer($userId));
    }

    /**
     * Determine if the target Contact's User is the same of the Appointment
     * issuer User.
     *
     * @return bool
     */
    public function isSelfIssued()
    {
        if (!$this->issuer) {
            return false;
        }
        if (!$this->contact) {
            return false;
        }
        if (!$this->contact->user) {
            return false;
        }

        return $this->issuer->id == $this->contact->user->id;
    }

    /**
     * Determine if the Serve action can be performed.
     *
     * @return bool
     */
    public function isServeable()
    {
        return $this->isActive() && $this->isDue();
    }

    /**
     * Determine if the Confirm action can be performed.
     *
     * @return bool
     */
    public function isConfirmable()
    {
        return $this->status == self::STATUS_RESERVED && $this->isFuture();
    }

    /**
     * Determine if the Annulate action can be performed.
     *
     * @return bool
     */
    public function isAnnulable()
    {
        return $this->isActive();
    }

    /////////////////////////
    // Hard Status Actions //
    /////////////////////////

    /**
     * Check and perform Confirm action.
     *
     * @return $this
     */
    public function doReserve()
    {
        if ($this->status === null) {
            $this->status = self::STATUS_RESERVED;
        }

        return $this;
    }

    /**
     * Check and perform Confirm action.
     *
     * @return $this
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
     * Check and perform Annulate action.
     *
     * @return $this
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
     * Check and perform Serve action.
     *
     * @return $this
     */
    public function doServe()
    {
        if ($this->isServeable()) {
            $this->status = self::STATUS_SERVED;

            return $this->save();
        }

        return $this;
    }
}
