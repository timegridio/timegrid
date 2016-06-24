<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Timegridio\Concierge\Models\Appointment;

class AppointmentWasCanceled extends Event
{
    use SerializesModels;

    public $user;

    public $appointment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Appointment $appointment)
    {
        $this->user = $user;
        $this->appointment = $appointment;
    }
}
