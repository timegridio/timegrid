<?php

namespace App\Widgets;

use Button;
use Icon;
use App\Appointment;
use Carbon\Carbon;
use Panel;

class AppointmentWidget
{
    protected $appointment = null;

    protected $fields = [];

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;

        $this->fields = ['code', 'contact', 'status', 'date', 'start_at', 'service', 'action', 'diffForHumans'];
    }

    public function only(Array $options)
    {
        $this->fields = array_intersect($options, $this->fields);
        return $this;
    }

    public function except(Array $options)
    {
        $this->fields = array_diff($this->fields, $options);
        return $this;
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
                if (!$this->appointment->isDue()) {
                    $out .= Button::success()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'confirm', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
                } else {
                    $out .= Button::normal()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'serve', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
                }
                break;
            case Appointment::STATUS_CONFIRMED:
                if ($this->appointment->isDue()) {
                    $out .= Button::normal()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn-xs', 'type' => 'button', 'data-action' => 'serve', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
                }
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
        if ($this->appointment->status == Appointment::STATUS_ANNULATED) {
            $code = '<s>'.$code.'</s>';
        }
        return '<code class="text-uppercase" title="'.$this->appointment->code.'">'.$code.'</code>';
    }

    public function dateLabel()
    {
        return $this->appointment->start_at->timezone($this->appointment->tz)->toDateString();
    }

    public function contactName()
    {
        return link_to(route('manager.business.contact.show', [$this->appointment->business->id, $this->appointment->contact->id]), $this->appointment->contact->fullname);
    }

    public function diffForHumans()
    {
        return $this->appointment->start_at->timezone($this->appointment->business->timezone)->diffForHumans();
    }

    public function row()
    {
        $class = $this->appointment->status == Appointment::STATUS_RESERVED  ? 'bg-warning' : '';
        $class = $this->appointment->status == Appointment::STATUS_CONFIRMED ? 'bg-success' : $class;
        $class = $this->appointment->status == Appointment::STATUS_ANNULATED ? 'bg-danger'  : $class;
        $highlight = $this->appointment->start_at->isToday() ? 'today' : '';

        $out  = "<tr id=\"{$this->appointment->code}\" class=\"{$class}\">";
        
        $cols = [];
        $cols['code']          = '<td>'. $this->code(4) .'</td>';
        $cols['contact']       = '<td>'. $this->contactName() .'</td>';
        $cols['status']        = '<td>'. $this->statusLabel() .'</td>';
        $cols['date']          = '<td>'. $this->dateLabel() .'</td>';
        $cols['start_at']      = "<td title=\"{$this->appointment->tz}\">".$this->appointment->start_at->timezone($this->appointment->tz)->toTimeString().'</td>';
        $cols['service']       = '<td>'. ($this->appointment->service ? $this->appointment->service->name : '') .'</td>';
        $cols['action']        = '<td>'. $this->actionButtons() .'</td>';
        $cols['diffForHumans'] = "<td class=\"{$highlight}\">". $this->diffForHumans() .'</td>';

        foreach ($this->fields as $field) {
            $out .= $cols[$field];
        }

        $out .= '</tr>';
        return $out;
    }

    public function table()
    {
        $out  = '<table class="table table-condensed table-hover">';
        $out .= $this->thead();
        $out .= '<tbody class="searchable">';
        foreach ($this->appointments as $appointment){
            $out .= $this->row();
        }
        $out .= '</tbody></table>';
        return $out;
    }

    public function thead()
    {
        $cols = [];
        $cols['code']          = '<th><span class="hidden-md">'. Icon::barcode() .'</span> <span class="hidden-xs hidden-sm">'. trans('user.appointments.index.th.code') . '</span></th>';
        $cols['contact']       = '<th><span class="hidden-md">'. Icon::user() .'</span> <span class="">'. trans('user.appointments.index.th.contact') . '</span></th>';
        $cols['status']        = '<th><span class="hidden-md">'. Icon::asterisk() .'</span> <span class="hidden-xs hidden-sm">'. trans('user.appointments.index.th.status') . '</span></th>';
        $cols['date']          = '<th><span class="hidden-md">'. Icon::calendar() .'</span> <span class="hidden-xs hidden-sm">'. trans('user.appointments.index.th.calendar') . '</span></th>';
        $cols['start_at']      = '<th><span class="hidden-md">'. Icon::time() .'</span> <span class="hidden-xs hidden-sm">'. trans('user.appointments.index.th.start_time') . '</span></th>';
        $cols['service']       = '<th><span class="hidden-md">'. Icon::briefcase() .'</span> <span class="hidden-xs hidden-sm">'. trans('user.appointments.index.th.service') . '</span></th>';
        $cols['action']        = '<th></th>';
        $cols['diffForHumans'] = '<th></th>';
        
        $out = '<thead><tr>';
        foreach ($this->fields as $field) {
            $out .= $cols[$field];
        }
        $out .= '</tr></thead>';
        return $out;
    }

    public function panel()
    {
        $header = $this->statusLabel();
        $footer = Icon::barcode() . '&nbsp;' . $this->code();

        switch ($this->appointment->status) {
            case Appointment::STATUS_ANNULATED:
                $panel = Panel::danger();
                $header .= '&nbsp;&nbsp;' . trans('appointments.alert.annulated');
                break;
            case Appointment::STATUS_CONFIRMED:
                $panel = Panel::success();
                break;
            case Appointment::STATUS_RESERVED:
                $panel = Panel::warning();
                break;
            case Appointment::STATUS_SERVED:
            default:
                $panel = Panel::normal();
                break;
        }

        $body  = '<ul class="list-group">';
        $body .= '<li class="list-group-item">';
        $body .= Icon::home(). '&nbsp;' . $this->appointment->business->name;
        $body .= '</li>';
        $body .= '<li class="list-group-item">';
        $body .= Icon::calendar() . '&nbsp;' . $this->appointment->start_at->toDateString();
        $body .= '</li>';
        $body .= '<li class="list-group-item">';
        $body .= '<span title="'.$this->appointment->tz.'">';
        $body .= Icon::time() . '&nbsp;' . $this->appointment->start_at->timezone($this->appointment->tz)->toTimeString() . '&nbsp;' . trans('appointments.text.to') . '&nbsp;' . $this->appointment->finish_at->timezone($this->appointment->tz)->toTimeString();
        $body .= '</span>';
        $body .= '</li>';
        $body .= '<li class="list-group-item">';
        $body .= Icon::hourglass() . '&nbsp;' . $this->appointment->duration . '&nbsp;' . trans('appointments.text.minutes');
        $body .= '</li>';
        $body .= '</ul>';
        
        $body .= '<p>'. $this->appointment->comments .'</p>';

        return $panel->withHeader($header)->withBody($body)->withFooter($footer);
    }
}
