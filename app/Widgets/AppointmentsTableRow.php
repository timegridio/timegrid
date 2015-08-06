<?php

namespace App\Widgets;

use Caffeinated\Widgets\Widget;
use App\Presenters\AppointmentPresenter;
use App\Appointment;
use App\User;
use App\Business;
use Button;
use Icon;

class AppointmentsTableRow extends Widget
{
    protected $profile;

    protected $user;

    protected $appointments;

    protected $class;

    public function __construct(Appointment $appointment, User $user)
    {
        $this->user = $user;

        $this->appointment = $appointment->getPresenter();
    }

    public function handle()
    {
        $this->profile = $this->getProfile();

        $this->class = $this->appointment->getPresenter()->statusToClass();

        return view("{$this->profile}.businesses.appointments.{$this->appointment->business->strategy}.widgets.tableRow", ['appointment' => $this->appointment, 'class' => $this->class, 'actionButtons' => $this->actionButtons($this->appointment->getPresenter())])->render();
    }

    private function getProfile()
    {
        return $this->user->isOwner($this->appointment->business) ? 'manager' : 'user';
    }

    public function actionButtons($appointment)
    {
        $method = $this->profile.'ActionButtons';
        return $this->$method($appointment);
    }

    private function getBtnCommonAttributes($appointment)
    {
        return ['class' => 'action btn', 'type' => 'button', 'data-business' => $appointment->business->id, 'data-appointment' => $appointment->id, 'data-code' => $appointment->code()];
    }

    public function managerActionButtons($appointment)
    {
        $commonAttributes = $this->getBtnCommonAttributes($appointment);
        $out = '<div class="btn-group">';
        if ($appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())->withAttributes(['data-action' => 'annulate'] + $commonAttributes);
        }
        if ($appointment->isConfirmable() && $appointment->needConfirmationOf(Appointment::PROFILE_MANAGER)) {
            $out .= Button::success()->withIcon(Icon::ok())->withAttributes(['data-action' => 'confirm'] + $commonAttributes);
        }
        if ($appointment->isServeable()) {
            $out .= Button::normal()->withIcon(Icon::ok())->withAttributes(['data-action' => 'serve'] + $commonAttributes);
        }
        $out .= '</div>';
        return $out;
    }

    public function userActionButtons($appointment)
    {
        $commonAttributes = $this->getBtnCommonAttributes($appointment);
        $out = '<div class="btn-group">';
        if ($appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())->withAttributes(['data-action' => 'annulate'] + $commonAttributes);
        }
        if ($appointment->isConfirmable() && $appointment->needConfirmationOf(Appointment::PROFILE_USER)) {
            $out .= Button::success()->withIcon(Icon::ok())->withAttributes(['data-action' => 'confirm'] + $commonAttributes);
        }
        $out .= '</div>';
        return $out;
    }
}
