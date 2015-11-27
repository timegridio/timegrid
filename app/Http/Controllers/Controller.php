<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesCommands;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    protected $log;

    public function __construct()
    {
        $this->log = app('log');
    }
}
