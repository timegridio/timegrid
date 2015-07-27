<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
        $users = \App\User::all();
        return view('root.dashboard', compact('users'));
    }
}
