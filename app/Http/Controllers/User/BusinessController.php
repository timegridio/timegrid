<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Fenos\Notifynder\Facades\Notifynder;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;

class BusinessController extends Controller
{
    /**
     * get Home.
     *
     * @param Business $business Business to display
     *
     * @return Response Rendered view for desired Business
     */
    public function getHome(Business $business, Concierge $concierge)
    {
        logger()->info(__CLASS__.':'.__METHOD__);
        logger()->info(sprintf("businessId:%s businessSlug:'%s'", $business->id, $business->slug));

        $businessName = $business->name;
        Notifynder::category('user.visitedShowroom')
                   ->from('App\Models\User', auth()->id())
                   ->to('Timegridio\Concierge\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName'))
                   ->send();

        $available = $concierge->business($business)->isBookable('today', 30);

        $appointment = $business->bookings()->forContacts(auth()->user()->contacts)->active()->first();

        return view('user.businesses.show', compact('business', 'available', 'appointment'));
    }

    /**
     * get List.
     *
     * @return Response Rendered view of all existing Businesses
     */
    public function getList()
    {
        logger()->info(__CLASS__.':'.__METHOD__);

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
        logger()->info(__CLASS__.':'.__METHOD__);

        $contacts = auth()->user()->contacts;

        return view('user.businesses.subscriptions', compact('contacts'));
    }
}
