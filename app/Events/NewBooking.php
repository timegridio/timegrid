<?php

namespace App\Events;

use App\User;
use App\Appointment;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewBooking extends Event
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
