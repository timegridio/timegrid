<?php

namespace App\Http\Controllers;

class WhoopsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Whoops Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders a user friendly exception handling.
    |
    */

    /**
     * Show the a friendly error screen to the user.
     *
     * @return Response
     */
    public function display()
    {
        logger()->info(__METHOD__);

        return view('whoops');
    }
}
