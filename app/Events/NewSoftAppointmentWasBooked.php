<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Timegridio\Concierge\Models\Appointment;

class NewSoftAppointmentWasBooked extends Event
{
    use SerializesModels;

    public $appointment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }
}
