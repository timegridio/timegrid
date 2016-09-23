<?php

namespace App\TG\Business;

use Timegridio\Concierge\Models\Business;

class Token
{
    private $business;

    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function generate()
    {
        return md5($this->business->slug.'>'.$this->business->created_at->timestamp);
    }
}
