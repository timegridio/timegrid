<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vacancy extends Model
{
    protected $fillable = ['business_id', 'service_id', 'date', 'start_at', 'finish_at', 'capacity'];

    protected $guarded = ['id'];

    protected $dates = ['start_at', 'finish_at'];

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function scopeForDate($query, Carbon $date)
    {
        return $query->where('date', '=', $date->toDateString());
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>', Carbon::now());
    }

    public function scopeForService($query, Service $service)
    {
        return $query->where('service_id', '=', $service->id);
    }

    public function isFull(Collection $appointments)
    {
        $slots = $this->capacity;
        foreach ($appointments as $appointment) {
            if ($this->holdsAppointment($appointment)) {
                $slots--;
            }
        }
        return $slots < 1;
    }

    public function holdsAppointment(Appointment $appointment)
    {
        return ($appointment->isActive() &&
                ($this->date == $appointment->date) &&
                ($this->service_id == $appointment->service_id) &&
                ($this->business_id == $appointment->business_id)
               );
    }

    public function holdsAnyAppointment(Collection $appointments)
    {
        foreach ($appointments as $appointment) {
            if ($this->holdsAppointment($appointment)) return true;
        }
        return false;
    }
}
