<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Business;
use Carbon\Carbon;
use Notifynder;
use Redirect;
use Flash;

/**
 * ToDo:
 *     - Access Notifynder with constructor dependency injection
 *     - Access Auth with constructor dependency injection
 *     - Access Business with dependency injection of a BusinessRepository
 */
class BusinessController extends Controller
{
    /**
     * get Home
     *
     * @param  Business $business Business to display
     * @return Response           Rendered view for desired Business
     */
    public function getHome(Business $business)
    {
        $this->log->info("BusinessController: getHome: businessId:{$business->id} businessSlug:({$business->slug})");

        $business_name = $business->name;
        Notifynder::category('user.visitedShowroom')
                   ->from('App\User', auth()->user()->id)
                   ->to('App\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        # $available = ConciergeServiceLayer::isAvailable($business, Carbon::now(), auth()->user());
        $available = true; /* ToDo */

        return view('user.businesses.show', compact('business', 'available'));
    }

    /**
     * get List
     *
     * @return Response Rendered view of all existing Businesses
     */
    public function getList()
    {
        $this->log->info('BusinessController: getList');
        $businesses = Business::all();
        return view('user.businesses.index', compact('businesses'));
    }

    /**
     * TODO: Selecting Business by Session should probably be deprecated
     *
     * get Select
     *
     * @param  Business $business Business to be selected
     * @return Response           Response provided by getHome()
     */
    public function getSelect(Business $business)
    {
        $this->log->info("BusinessController: getSelect businessId:{$business->id}");
        session()->set('selected.business', $business);
        return $this->getHome($business);
    }

    /**
     * TODO: Should be named getFavorites
     *
     * get Subscriptions
     *
     *      Gets the User profile Contacts that MAY BE subscribed to Businesses
     *
     * @return Response Rendered view of the Contacts linked to the
     *                  requesting User
     */
    public function getSubscriptions()
    {
        $this->log->info('BusinessController: getSubscriptions');
        $contacts = auth()->user()->contacts;
        return view('user.businesses.subscriptions', compact('contacts'));
    }
}
