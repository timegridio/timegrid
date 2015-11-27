<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesCommands;
use App\Traits\LogsMessages;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests, LogsMessages;
}
