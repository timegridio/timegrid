<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;

class WizardController extends Controller
{
    public function getHome()
    {
        if (Auth::user()->hasBusiness()) {
            return Redirect::route('manager.business.index');
        } else {
            if (Auth::user()->hasContacts()) {
                return Redirect::route('user.businesses.list');
            }
        }
        return view('wizard');
    }

    public function getWelcome()
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
