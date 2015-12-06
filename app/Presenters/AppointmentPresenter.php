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
        return substr($this->wrappedObject->hash, 0, $this->wrappedObject->business->pref('appointment_code_length'));
    }

    public function date()
    {
        return $this->wrappedObject->start_at->timezone($this->wrappedObject->business->timezone)->toDateString();
    }

    public function time()
    {
        return $this->wrappedObject->start_at->timezone($this->wrappedObject->business->timezone)->toTimeString();
    }

    public function diffForHumans()
    {
        return $this->wrappedObject->start_at->timezone($this->wrappedObject->business->timezone)->diffForHumans();
    }

    public function status()
    {
        return trans('appointments.status.'.$this->wrappedObject->statusLabel);
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
