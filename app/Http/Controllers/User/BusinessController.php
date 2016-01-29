<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Concierge\Concierge;
use Concierge\VacancyManager;
use Fenos\Notifynder\Facades\Notifynder;

class BusinessController extends Controller
{
    /**
     * get Home.
     *
     * @param Business $business Business to display
     *
     * @return Response Rendered view for desired Business
     */
    public function getHome(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf("businessId:%s businessSlug:'%s'", $business->id, $business->slug));

        $businessName = $business->name;
        Notifynder::category('user.visitedShowroom')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName'))
                   ->send();

        $concierge = new Concierge(new VacancyManager());

        $concierge->setBusiness($business);

        $available = $concierge->isAvailable(auth()->user());

        $appointment = $concierge->getNextAppointmentFor(auth()->user()->contacts);

        return view('user.businesses.show', compact('business', 'available', 'appointment'));
    }

    /**
     * get List.
     *
     * @return Response Rendered view of all existing Businesses
     */
    public function getList()
    {
        logger()->info(__METHOD__);

        $businesses = Business::all();

        return view('user.businesses.index', compact('businesses'));
    }

    ////////////////
    // FOR REVIEW //
    ////////////////

    /**
     * Gets the User profile Contacts that MAY BE subscribed to Businesses.
     *
     * @return Response Rendered view of the Contacts linked to the requesting User
     */
    public function getSubscriptions()
    {
        logger()->info(__METHOD__);

        $contacts = auth()->user()->contacts;

        return view('user.businesses.subscriptions', compact('contacts'));
    }
}
