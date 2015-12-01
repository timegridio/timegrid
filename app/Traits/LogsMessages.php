<?php

namespace App\Traits;

trait LogsMessages
{
    protected $log;

    public function __construct()
    {
        $this->log = app('log');
    }
}
