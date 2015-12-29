<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesCommands, ValidatesRequests;

    public function __construct()
    {
        view()->share('isGuest', auth()->guest());
        view()->share('signedIn', auth()->check());
        view()->share('user', auth()->user());
    }
}
