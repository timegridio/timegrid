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

    protected $profile = null;

    protected $options = ['display_actions' => false];

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;

        $this->fields = ['code', 'contact', 'status', 'date', 'start_at', 'service', 'action', 'business', 'diffForHumans'];
    }

    public function forManager()
    {
        $this->profile(Appointment::PROFILE_MANAGER);
        return $this;
    }

    public function profile($profile = Appointment::PROFILE_USER)
    {
        $this->profile = $profile;
        return $this;
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

    public function actions($enable = true)
    {
        $this->options['display_actions'] = $enable;
        return $this;
    }

    public function actionButtons()
    {
        return $this->profile == Appointment::PROFILE_MANAGER ? $this->managerActionButtons() : $this->userActionButtons();
    }

    public function managerActionButtons()
    {
        $out = '<div class="btn-group">';

        if ($this->appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())->withAttributes(['class' => 'action btn', 'type' => 'button', 'data-action' => 'annulate', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
        }
        if ($this->appointment->isConfirmable() && $this->appointment->needConfirmationOf(Appointment::PROFILE_MANAGER)) {
            $out .= Button::success()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn', 'type' => 'button', 'data-action' => 'confirm', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
        }
        if ($this->appointment->isServeable()) {
            $out .= Button::normal()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn', 'type' => 'button', 'data-action' => 'serve', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
        }

        $out .= '</div>';
        return $out;
    }

    public function userActionButtons()
    {
        $out = '<div class="btn-group">';

        if ($this->appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())->withAttributes(['class' => 'action btn', 'type' => 'button', 'data-action' => 'annulate', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
        }
        if ($this->appointment->isConfirmable() && $this->appointment->needConfirmationOf(Appointment::PROFILE_USER)) {
            $out .= Button::success()->withIcon(Icon::ok())->withAttributes(['class' => 'action btn', 'type' => 'button', 'data-action' => 'confirm', 'data-business' => $this->appointment->business->id, 'data-appointment' => $this->appointment->id, 'data-code' => $this->appointment->code]);
        }
        
        $out .= '</div>';
        return $out;
    }

    public function code()
    {
        $code = $this->appointment->code;
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
        $cols['code']          = '<td>'. $this->code() .'</td>';
        $cols['contact']       = '<td>'. $this->contactName() .'</td>';
        $cols['status']        = '<td>'. $this->statusLabel() .'</td>';
        $cols['date']          = '<td>'. $this->dateLabel() .'</td>';
        $cols['start_at']      = "<td title=\"{$this->appointment->tz}\">".$this->appointment->start_at->timezone($this->appointment->tz)->toTimeString().'</td>';
        $cols['service']       = '<td>'. ($this->appointment->service ? $this->appointment->service->name : '') .'</td>';
        $cols['action']        = '<td>'. $this->actionButtons() .'</td>';
        $cols['business']      = "<td>". $this->appointment->business->name .'</td>';
        $cols['diffForHumans'] = "<td class=\"{$highlight}\">". $this->diffForHumans() .'</td>';

        foreach ($this->fields as $field) {
            $out .= $cols[$field];
        }

        $out .= '</tr>';
        return $out;
    }

    public function panel()
    {
        $header = $this->statusLabel();
        $footer = Icon::barcode() . '&nbsp;' . $this->code();
        $class = '';

        switch ($this->appointment->status) {
            case Appointment::STATUS_ANNULATED:
                $panel = Panel::danger();
                $header .= '&nbsp;&nbsp;' . trans('appointments.alert.annulated');
                $class = 'annulated';
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

        $body  = "<ul class=\"list-group appointmentinfo $class\">";
        $body .= '<li class="list-group-item">';
        $body .= Icon::home(). '&nbsp;' . $this->appointment->business->name;
        $body .= '</li>';
        $body .= '<li class="list-group-item">';
        $body .= Icon::calendar() . '&nbsp;' . $this->appointment->start_at->toDateString() . '&nbsp;&nbsp;' . '<span class="text-muted"><small>' . $this->appointment->start_at->diffForHumans() . '</small></span>';
        $body .= '</li>';
        $body .= '<li class="list-group-item">';
        $body .= '<span title="'.$this->appointment->tz.'">';
        #$body .= Icon::time() . '&nbsp;' . $this->appointment->start_at->timezone($this->appointment->tz)->toTimeString() . '&nbsp;' . trans('appointments.text.to') . '&nbsp;' . $this->appointment->finish_at->timezone($this->appointment->tz)->toTimeString();
        $body .= Icon::time() . '&nbsp;' . $this->appointment->start_at->timezone($this->appointment->tz)->toTimeString();
        $body .= '</span>';
        $body .= '</li>';

        if($this->options['display_actions'] && $this->appointment->isActive())
        {
            $body .= '<li class="list-group-item">';
            $body .= $this->actionButtons();
            $body .= '</li>';
        }
        $body .= '</ul>';
        
        if ($this->appointment->comments) $body .= '<p>'. $this->appointment->comments .'</p>';

        return $panel->withAttributes(['id' => $this->appointment->code])->withHeader($header)->withBody($body)->withFooter($footer);
    }

    public function mini($title = '')
    {
        $header = '';
        switch ($this->appointment->status) {
            case Appointment::STATUS_ANNULATED:
                $panel = Panel::danger();
                $header .= Icon::alert() . '&nbsp;&nbsp;' . trans('appointments.status.annulated');
                break;
            case Appointment::STATUS_CONFIRMED:
                $header = $title . '&nbsp;' . $this->appointment->start_at->timezone($this->appointment->tz)->diffForHumans();
                $panel = Panel::success();
                break;
            case Appointment::STATUS_RESERVED:
                $header = $title . '&nbsp;' . $this->appointment->start_at->timezone($this->appointment->tz)->diffForHumans();
                $panel = Panel::warning();
                break;
            case Appointment::STATUS_SERVED:
            default:
                $panel = Panel::normal();
                break;
        }

        $body   = Icon::calendar() . '&nbsp;' . $this->appointment->start_at->toDateString();
        $body  .= '&nbsp;&nbsp;' . Icon::time() . '&nbsp;' . $this->appointment->start_at->timezone($this->appointment->tz)->toTimeString();
        $body  .= '&nbsp;&nbsp;' . Icon::user() . '&nbsp;' . $this->appointment->contact->fullname;
        $footer = Icon::barcode() . '&nbsp;' . $this->code() . '&nbsp;&nbsp;' . $this->statusLabel();

        return $panel->withAttributes(['id' => $this->appointment->code])->withHeader($header)->withBody($body)->withFooter($footer);
    }
}
