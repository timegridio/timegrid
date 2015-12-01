<?php

namespace App\Widgets;

use Icon;
use Button;
use App\Models\User;
use App\Models\Appointment;
use Caffeinated\Widgets\Widget;

/**
 * ToDo: Needs refactor
 */

/**
 * AppointmentTableRow Widget
 *
 * Builds an HTML Table Row with Appointment details.
 * The row is to be placed into an AppointmentsTable widget.
 */
class AppointmentsTableRow extends Widget
{
    protected $profile;

    protected $user;

    protected $appointment;

    protected $class;

    public function __construct(Appointment $appointment, User $user)
    {
        $this->user = $user;
        $this->appointment = $appointment;
    }

    public function handle()
    {
        $this->profile = $this->getProfile();

        $this->class = $this->appointment->getPresenter()->statusToClass();

        $viewPath = "{$this->profile}.businesses.appointments.{$this->appointment->business->strategy}.widgets.tableRow";
        return view($viewPath, ['appointment' => $this->appointment->getPresenter(),
                                'class' => $this->class,
                                'actionButtons' => $this->actionButtons($this->appointment->getPresenter())]);
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
        return ['class' => 'action btn',
                'type' => 'button',
                'data-business' => $appointment->business->id,
                'data-appointment' => $appointment->id,
                'data-code' => $appointment->getPresenter()->code()];
    }

    public function managerActionButtons($appointment)
    {
        $commonAttributes = $this->getBtnCommonAttributes($appointment);
        $out = '<div class="btn-group">';
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
        $out .= '</div>';
        return $out;
    }

    public function userActionButtons($appointment)
    {
        $commonAttributes = $this->getBtnCommonAttributes($appointment);
        $out = '<div class="btn-group">';
        if ($appointment->isAnnulable()) {
            $out .= Button::danger()->withIcon(Icon::remove())
                                    ->withAttributes(['data-action' => 'annulate'] + $commonAttributes);
        }
        if ($appointment->isConfirmable() && $appointment->needConfirmationOf(Appointment::PROFILE_USER)) {
            $out .= Button::success()->withIcon(Icon::ok())
                                     ->withAttributes(['data-action' => 'confirm'] + $commonAttributes);
        }
        $out .= '</div>';
        return $out;
    }
}
