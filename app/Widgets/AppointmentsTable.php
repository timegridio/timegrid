<?php

namespace App\Widgets;

use App\User;
use App\Business;
use Caffeinated\Widgets\Widget;
use Illuminate\Support\Collection;

/**
 * ToDo: Needs refactor
 */

/**
 * AppointmentTable Widget
 *
 * Builds an HTML Table with Appointment details.
 * The Table should be able to be placed in almost any page.
 */

class AppointmentsTable extends Widget
{
    protected $profile;

    protected $user;

    protected $appointments;

    protected $business;

    public function __construct(Collection $appointments, User $user, Business $business)
    {
        $this->user = $user;
        $this->appointments = $appointments;
        $this->business = $business;
    }

    public function handle()
    {
        $this->profile = $this->getProfile();
        return view("{$this->profile}.businesses.appointments.{$this->business->strategy}.widgets.table", 
            ['appointments' => $this->appointments])->render();
    }

    private function getProfile()
    {
        return $this->user->isOwner($this->business) ? 'manager' : 'user';
    }
}
