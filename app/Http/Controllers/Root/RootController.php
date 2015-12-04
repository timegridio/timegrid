<?php

namespace App\Http\Controllers\Root;

use App\Models\User;
use Laracasts\Flash\Flash;
use App\Http\Controllers\Controller;

class RootController extends Controller
{
    /**
     * get Index
     *
     * @return Response Show Root dashboard
     */
    public function getIndex()
    {
        $this->log->info(__METHOD__);
        $this->log->warning('[ROOT ACCESS]');

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $users = User::all();

        return view('root.dashboard', compact('users'));
    }

    /**
     * Switch authentication into another user for support purpose
     *
     * @return Response Show Root dashboard
     */
    public function getSudo($userId)
    {
        $this->log->info(__METHOD__);

        $this->log->warning("[!] ROOT SUDO userId:{$userId}");
        auth()->loginUsingId($userId);
        
        Flash::warning('ADVICE: THIS IS FOR AUTHORIZED USE ONLY AND YOUR ACTIONS ARE BEING RECORDERED !!!');
        return redirect()->route('user.businesses.list');
    }
}
