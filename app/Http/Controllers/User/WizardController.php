<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class WizardController extends Controller
{
    public function getIndex()
    {
        return view('wizard');
    }

    public function getPricing()
    {
        return view('manager.pricing');
    }

    public function getTerms()
    {
        return view('manager.terms');
    }
}
