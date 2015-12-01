<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

/*******************************************************************************
 * The Wizard will present either a guided step-by-step configuration for
 * businesses owners, or business directory listing for new users acting as
 * customers. It will also send them to default views if they are regular users.
 ******************************************************************************/
class WizardController extends Controller
{
    /**
     * get home page for old users and wizard for new users
     *
     * @return Response Rendered view of Wizard or Redirect
     */
    public function getWizard()
    {
        $this->log->info(__METHOD__);

        if (auth()->user()->hasBusiness()) {
            $this->log->info('  User has Business');
            return redirect()->route('manager.business.index');
        }

        if (auth()->user()->hasContacts()) {
            $this->log->info('  User has Contacts');
            return redirect()->route('user.businesses.list');
        }

        return view('wizard');
    }

    /**
     * get Welcome page
     *
     * @return Response Rendered view for Wizard
     */
    public function getWelcome()
    {
        $this->log->info(__METHOD__);

        return view('wizard');
    }

    /**
     * get Pricing
     *
     * @return Response Returns pricing table
     */
    public function getPricing()
    {
        $this->log->info(__METHOD__);

        return view('manager.pricing');
    }

    /**
     * get Terms and Conditions
     *
     * @return Response Rendered view for Terms and Conditions of use
     */
    public function getTerms()
    {
        $this->log->info(__METHOD__);

        return view('manager.terms');
    }
}
