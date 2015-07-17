<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RootController extends Controller
{
    public function getIndex()
    {
        $users = \App\User::all();
        return view('root.dashboard', compact('users'));
    }
}
