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
        return $this->wrappedObject->start_at->toDateString();
    }

    public function status()
    {
        return trans('appointments.status.'.$this->wrappedObject->statusLabel);
    }

    public function statusToClass()
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
}
