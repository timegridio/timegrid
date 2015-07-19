<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;

class WizardController extends Controller
{
    public function getWelcome()
    {
        if (!Session::get('oldvisitor')) {
            Session::set('oldvisitor', true);
            return view('wizard');
        } else {
            return Redirect::route('user.businesses.list');
        }
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
