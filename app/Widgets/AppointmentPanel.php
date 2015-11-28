<?php

namespace App\Widgets;

use Icon;
use Panel;
use Button;
use App\User;
use App\Appointment;
use Caffeinated\Widgets\Widget;
use App\Presenters\AppointmentPresenter;

/**
 * ToDo: Needs refactor
 */

/**
 * AppointmentPanel Widget
 *
 * Builds an HTML Panel with Appointment details.
 * The Panel should be able to be placed in almost any page.
 */
class AppointmentPanel extends Widget
{
    protected $profile;

    protected $user;

    protected $appointments;

    public function __construct(Appointment $appointment, User $user)
    {
        $this->user = $user;
        $this->appointment = $appointment;
    }

    public function handle()
    {
        $this->profile = $this->getProfile();
        return $this->panel($this->appointment->getPresenter());
    }

    private function getProfile()
    {
        return $this->user->isOwner($this->appointment->business) ? 'manager' : 'user';
    }

    public function panel(AppointmentPresenter $appointment)
    {
        $header = $appointment->status();

        $footer = Icon::barcode() . '&nbsp;<code>' . $appointment->code() .'</code>';

        $panel = $this->getPanelWithStatus();
        $body  = $this->buildBody($appointment);

        return $panel->withAttributes(['id' => $appointment->code()])
                     ->withHeader($header)
                     ->withBody($body)
                     ->withFooter($footer);
    }

    public function getPanelWithStatus()
    {
        return Panel::setType('panel-'.$this->statusToClass());
    }

    public function buildBody($appointment)
    {
        $class = $this->statusToClass();
        $body  = "<ul class=\"list-group appointmentinfo $class\">";
        $body .= '<li class="list-group-item">';
        $body .= Icon::home(). '&nbsp;' . $appointment->business->name;
        $body .= '</li>';
        if ($appointment->business->postal_address) {
            $body .= '<li class="list-group-item">';
            $body .= Icon::map_marker(). '&nbsp;' . $appointment->business->postal_address;
            $body .= '</li>';
        }
        if ($appointment->business->phone) {
            $body .= '<li class="list-group-item">';
            $body .= Icon::phone(). '&nbsp;' . $appointment->business->phone;
            $body .= '</li>';
        }
        $body .= '<li class="list-group-item">';
        $body .= Icon::calendar() . '&nbsp;' . $appointment->date() . '&nbsp;&nbsp;' .
                                    '<span class="text-muted"><small>' .
                                    $appointment->start_at->diffForHumans() .
                                    '</small></span>';
        $body .= '</li>';
        $body .= '<li class="list-group-item">';
        $body .= '<span title="'.$appointment->tz.'">';
        $body .= Icon::time() . '&nbsp;' . $appointment->start_at->timezone($appointment->tz)->toTimeString();
        $body .= '</span>';
        $body .= '<li class="list-group-item">';
        $body .= Icon::tag(). '&nbsp;' . $appointment->service->name;
        $body .= '</li>';
        if ($appointment->service->prerequisites) {
            $body .= '<li class="list-group-item">';
            $body .= Icon::alert(). '&nbsp;' . $appointment->service->prerequisites;
            $body .= '</li>';
        }
        if ($appointment->comments) {
            $body .= '<li class="list-group-item">';
            $body .= Icon::pencil(). '&nbsp;' . $appointment->comments;
            $body .= '</li>';
        }
        $body .= '</li>';
        
        $body .= '</ul>';

        $body .= $this->actionButtons($appointment);

        return $body;
    }

    public function statusToClass()
    {
        switch ($this->appointment->status) {
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

    public function actionButtons($appointment)
    {
        $method = $this->profile.'ActionButtons';
        return $this->$method($appointment);
    }

    private function getBtnCommonAttributes($appointment)
    {
        return ['class' => 'action', 
                'data-business' => $appointment->business->id,
                'data-appointment' => $appointment->id,
                'data-code' => $appointment->code()];
    }

    public function managerActionButtons($appointment)
    {
        $commonAttributes = $this->getBtnCommonAttributes($appointment);
        $out = '<span class="btn-group">';
        if ($appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())
                                    ->withAttributes(['data-action' => 'annulate'] + $commonAttributes);
        }
        if ($appointment->isConfirmable() && $appointment->needConfirmationOf(Appointment::PROFILE_MANAGER)) {
            $out .= Button::success()->withIcon(Icon::ok())
                                     ->withAttributes(['data-action' => 'confirm'] + $commonAttributes);
        }
        if ($appointment->isServeable()) {
            $out .= Button::normal()->withIcon(Icon::ok())
                                    ->withAttributes(['data-action' => 'serve'] + $commonAttributes);
        }
        $out .= '</span>';
        return $out;
    }

    public function userActionButtons($appointment)
    {
        $commonAttributes = $this->getBtnCommonAttributes($appointment);
        $out = '<span class="btn-group">';
        if ($appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())
                                    ->withAttributes(['data-action' => 'annulate'] + $commonAttributes);
        }
        if ($appointment->isConfirmable() && $appointment->needConfirmationOf(Appointment::PROFILE_USER)) {
            $out .= Button::success()->withIcon(Icon::ok())
                                     ->withAttributes(['data-action' => 'confirm'] + $commonAttributes);
        }
        $out .= '</span>';
        return $out;
    }
}
