<?php

namespace App\Presenters;

use App\Models\Appointment;
use McCool\LaravelAutoPresenter\BasePresenter;

class AppointmentPresenter extends BasePresenter
{
    public function __construct(Appointment $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function code()
    {
        $length = $this->wrappedObject->business->pref('appointment_code_length');

        return strtoupper(substr($this->wrappedObject->hash, 0, $length));
    }

    public function date($format = 'Y-m-d')
    {
        if ($this->wrappedObject->start_at->isToday()) {
            return studly_case(trans('appointments.text.today'));
        }

        if ($this->wrappedObject->start_at->isTomorrow()) {
            return studly_case(trans('appointments.text.tomorrow'));
        }

        return $this->wrappedObject
                    ->start_at
                    ->timezone($this->wrappedObject->business->timezone)
                    ->format($format);
    }

    public function arriveAt()
    {
        $flexibleArrival = $this->wrappedObject->business->pref('appointment_flexible_arrival');

        if (!$flexibleArrival) {
            return $this->time;
        }

        $from = $this->wrappedObject
                    ->vacancy
                    ->start_at
                    ->timezone($this->wrappedObject->business->timezone)
                    ->format(env('DISPLAY_TIME_FORMAT', 'h:i A'));

        $to = $this->wrappedObject
                   ->vacancy
                   ->finish_at
                   ->timezone($this->wrappedObject->business->timezone)
                   ->format(env('DISPLAY_TIME_FORMAT', 'h:i A'));

        return ucwords(trans('appointments.text.from_to', compact('from', 'to')));
    }

    public function time()
    {
        return $this->wrappedObject
                    ->start_at
                    ->timezone($this->wrappedObject->business->timezone)
                    ->format(env('DISPLAY_TIME_FORMAT', 'h:i A'));
    }

    public function finishTime()
    {
        return $this->wrappedObject
                    ->finish_at
                    ->timezone($this->wrappedObject->business->timezone)
                    ->format(env('DISPLAY_TIME_FORMAT', 'h:i A'));
    }

    public function diffForHumans()
    {
        return $this->wrappedObject->start_at->timezone($this->wrappedObject->business->timezone)->diffForHumans();
    }

    public function phone()
    {
        return $this->wrappedObject->business->phone;
    }

    public function location()
    {
        return $this->wrappedObject->business->postal_address;
    }

    public function statusLetter()
    {
        return substr(trans('appointments.status.'.$this->wrappedObject->statusLabel), 0, 1);
    }

    public function status()
    {
        return trans('appointments.status.'.$this->wrappedObject->statusLabel);
    }

    public function statusIcon()
    {
        return '<span class="label label-'.$this->statusToCssClass().'">'.$this->statusLetter.'</span>';
    }

    public function statusToCssClass()
    {
        switch ($this->wrappedObject->status) {
            case Appointment::STATUS_ANNULATED:
                return 'danger';
                break;
            case Appointment::STATUS_CONFIRMED:
                return 'success';
                break;
            case Appointment::STATUS_RESERVED:
                return 'warning';
                break;
            case Appointment::STATUS_SERVED:
            default:
                return 'default';
                break;
        }
    }

    public function panel()
    {
        return view('widgets.appointment.panel._body', ['appointment' => $this, 'user' => auth()->user()])->render();
    }

    public function row()
    {
        return view('widgets.appointment.row._body', ['appointment' => $this, 'user' => auth()->user()])->render();
    }
}
