<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Redirect;
use Auth;

class WizardController extends Controller
{
    /**
     * get Home
     *
     *      Checks if the user is already manager or user and returns appropiate
     *      Redirect to their views or defaults to Wizard
     *
     * @return Response Rendered view of Wizard
     */
    public function getHome()
    {
        $this->log->info('WizardController: getHome');

        if (Auth::user()->hasBusiness()) {
            $this->log->info('WizardController: getHome: User has Business');
            return Redirect::route('manager.business.index');
        } else {
            $this->log->info('WizardController: getHome: User has Contacts');
            if (Auth::user()->hasContacts()) {
                return Redirect::route('user.businesses.list');
            }
        }
        $this->log->info('WizardController: getHome: Displaying Wizard');
        return view('wizard');
    }

    /**
     * get Welcome
     *
     * @return Response Rendered view for Wizard
     */
    public function getWelcome()
    {
        $this->log->info('WizardController: getWelcome');
        return view('wizard');
    }

    /**
     * get Pricing
     *
     * @return Response Returns pricing table
     */
    public function getPricing()
    {
        $this->log->info('WizardController: getPricing');
        return view('manager.pricing');
    }

    /**
     * get Terms and Conditions
     *
     * @return Response Rendered view for Terms and Conditions of use
     */
    public function getTerms()
    {
        $this->log->info('WizardController: getTerms');
        return view('manager.terms');
    }
}
