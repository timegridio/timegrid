<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Log;

class RootController extends Controller
{
    /**
     * get Index
     * 
     * @return Response Show Root dashboard
     */
    public function getIndex()
    {
        Log::warning('ROOT INDEX');
        $users = \App\User::all();
        return view('root.dashboard', compact('users'));
    }
}
