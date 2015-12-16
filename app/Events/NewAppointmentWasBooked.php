<?php

namespace App\Events;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class NewAppointmentWasBooked extends Event
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

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
