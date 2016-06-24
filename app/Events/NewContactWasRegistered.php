<?php

namespace App\Events;

use Timegridio\Concierge\Models\Contact;
use Illuminate\Queue\SerializesModels;

class NewContactWasRegistered extends Event
{
    use SerializesModels;

    public $contact;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
}
