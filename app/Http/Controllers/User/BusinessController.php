<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Notifynder;
use Session;
use Redirect;
use App\Business;
use Flash;

class BusinessController extends Controller
{
    public function getHome(Business $business)
    {
        $business_name = $business->name;
        Notifynder::category('user.visitedShowroom')
                   ->from('App\User', \Auth::user()->id)
                   ->to('App\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        return view('user.businesses.show', compact('business'));
    }

    public function getList()
    {
        $businesses = Business::all();
        return view('user.businesses.index', compact('businesses'));
    }

    public function getSelect(Business $business)
    {
        Session::set('selected.business', $business);
        return $this->getHome($business);
    }

    public function getSuscriptions()
    {
        $contacts = \Auth::user()->contacts;
        return view('user.businesses.suscriptions', compact('contacts'));
    }
}
