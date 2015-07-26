<?php

namespace App\Presenters;

use App\Appointment;

class AppointmentPresenter extends \Robbo\Presenter\Presenter
{
    public function code()
    {
        return substr($this->hash, 0, $this->business->pref('appointment_code_length'));
    }

    public function date()
    {
        return $this->start_at->toDateString();
    }

    public function status()
    {
        return trans('appointments.status.'.$this->statusLabel);
    }

    public function statusToClass() 
    {
        switch ($this->status) {
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
