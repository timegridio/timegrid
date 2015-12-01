<?php

namespace App\Http\Controllers\Root;

use App\Models\User;
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

        $users = User::all();
        return view('root.dashboard', compact('users'));
    }
}
