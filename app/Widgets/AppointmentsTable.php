<?php

namespace App\Widgets;

use Caffeinated\Widgets\Widget;
use App\Presenters\AppointmentPresenter;
use Illuminate\Support\Collection;
use App\User;
use App\Business;

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
        return view("{$this->profile}.businesses.appointments.{$this->business->strategy}.widgets.table", ['appointments' => $this->appointments])->render();
    }

    private function getProfile()
    {
        return $this->user->isOwner($this->business) ? 'manager' : 'user';
    }
}
