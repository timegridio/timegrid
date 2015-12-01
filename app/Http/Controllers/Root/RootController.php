<?php

namespace App\Http\Controllers\Root;

use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
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
        $this->log->warning('ROOT INDEX');
        $users = User::all();
        return view('root.dashboard', compact('users'));
    }
}
