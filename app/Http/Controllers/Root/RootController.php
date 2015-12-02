<?php

namespace App\Http\Controllers\Root;

use App\Models\User;
use Laracasts\Flash\Flash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

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

        $users = User::all();
        return view('root.dashboard', compact('users'));
    }

    public function getSudo($userId)
    {
        $this->log->info(__METHOD__);

        auth()->loginUsingId($userId);
        $this->log->warning("[!] ROOT SUDO userId:{$userId}");
        
        Flash::warning('!!! ADVICE THIS FOR IS AUTHORIZED USE ONLY AND YOUR ACTION IS RECORDERED !!!');
        return Redirect::route('user.businesses.list');
    }
}
