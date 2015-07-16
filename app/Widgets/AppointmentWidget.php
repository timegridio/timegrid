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
        $out = '<div class="btn-group">';
        switch ($this->appointment->status) {
            case Appointment::STATUS_RESERVED:
                $out .= Button::danger()->withIcon(Icon::remove())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'annulate', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
                if(!$this->appointment->isDue())
                {
                    $out .= Button::success()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'confirm', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);  
                } 
                else
                {
                    $out .= Button::normal()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'serve', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
                }
                break;
            case Appointment::STATUS_CONFIRMED:
                if($this->appointment->isDue()) $out .= Button::normal()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'serve', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
                break;
            case Appointment::STATUS_ANNULATED:
                break;
            default:
                break;
        }
        $out .= '</div>';
        return $out;
    }

    public function code($length = 6)
    {
        $code = substr($this->appointment->code, 0, $length);
        if($this->appointment->status == Appointment::STATUS_ANNULATED) $code = '<s>'.$code.'</s>';
        return '<code class="text-uppercase" title="'.$this->appointment->code.'">'.$code.'</code>';
    }

    public function dateLabel()
    {
        return $this->appointment->start_at->timezone($this->appointment->tz)->toDateString();
    }

    public function contactName()
    {
        return link_to( route('manager.business.contact.show', [$this->appointment->business->id, $this->appointment->contact->id]), $this->appointment->contact->fullname);
    }

    public function diffForHumans()
    {
        return $this->appointment->start_at->timezone($this->appointment->business->timezone)->diffForHumans();
    }

    public function fullrow()
    {
        $class = $this->appointment->status == Appointment::STATUS_RESERVED  ? 'bg-warning' : '';
        $class = $this->appointment->status == Appointment::STATUS_CONFIRMED ? 'bg-success' : $class;
        $class = $this->appointment->status == Appointment::STATUS_ANNULATED ? 'bg-danger'  : $class;
        $highlight = $this->appointment->start_at->isToday() ? 'today' : '';

        $out  = "<tr id=\"{$this->appointment->code}\" class=\"{$class}\">";
        $out .= '<td>'. $this->code(4) .'</td>';
        $out .= '<td>'. $this->contactName() .'</td>';
        $out .= '<td>'. $this->statusLabel() .'</td>';
        $out .= '<td>'. $this->dateLabel() .'</td>';
        $out .= "<td title=\"{$this->appointment->tz}\">".$this->appointment->start_at->timezone($this->appointment->tz)->toTimeString().'</td>';
        $out .= '<td>'. ($this->appointment->service ? $this->appointment->service->name : '') .'</td>';
        $out .= '<td>'. $this->actionButtons() .'</td>';
        $out .= "<td class=\"{$highlight}\">". $this->diffForHumans() .'</td>';
        $out .= '</tr>';
        return $out;
    }
}
