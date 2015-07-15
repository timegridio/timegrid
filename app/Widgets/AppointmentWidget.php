<?php

namespace App\Widgets;

use Button;
use Icon;
use App\Appointment;
use Carbon\Carbon;

class AppointmentWidget
{
    protected $appointment = null;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function statusLabel()
    {
        switch ($this->appointment->status) {
            case Appointment::STATUS_RESERVED:
                $class = 'warning';
                break;
            case Appointment::STATUS_CONFIRMED:
                $class = 'success';
                break;
            case Appointment::STATUS_ANNULATED:
                $class = 'danger';
                break;
            case Appointment::STATUS_SERVED:
                $class = 'default';
                break;
            default:
                
                break;
        }
        return '<span class="label label-'.$class.'">'.trans('appointments.status.'.$this->appointment->statusLabel).'</span>';
    }

    public function actionButtons()
    {
        switch ($this->appointment->status) {
            case Appointment::STATUS_RESERVED:
                return Button::danger()->withIcon(Icon::remove())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'annulate', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id]) .
                       Button::success()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'confirm', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id]);
                break;
            case Appointment::STATUS_CONFIRMED:
                return Button::normal()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'serve', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id]);
                break;
            case Appointment::STATUS_ANNULATED:
                return '';
                break;
            
            default:
                
                break;
        }
    }

    public function code($length = 6)
    {
        return '<code class="text-uppercase" title="'.substr($this->appointment->code, 0, 8).'">'.substr($this->appointment->code, 0, $length).'</code>';
    }

    public function dateLabel()
    {
        $class = $this->appointment->start_at->isToday() ? 'bg-success' : '';
        return "<span class=\"$class\">".$this->appointment->start_at->timezone($this->appointment->tz)->toDateString().'</span>';
    }

    public function fullrow()
    {
        $out  = '<tr>';
        $out .= '<td>'. $this->code(4) .'</td>';
        $out .= '<td>'. $this->statusLabel() .'</td>';
        $out .= '<td>'. $this->dateLabel() .'</td>';
        $out .= "<td title=\"{$this->appointment->tz}\">".$this->appointment->start_at->timezone($this->appointment->tz)->toTimeString().'</td>';
        $out .= '<td>'. ($this->appointment->service ? $this->appointment->service->name : '') .'</td>';
        $out .= '<td>'. $this->actionButtons() .'</td>';
        $out .= '</tr>';
        return $out;
    }
}
