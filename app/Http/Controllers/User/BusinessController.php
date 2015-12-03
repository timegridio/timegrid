<?php

namespace App\Http\Controllers\User;

use Flash;
use Carbon\Carbon;
use App\Models\Business;
use App\Services\VacancyService;
use App\Services\ConciergeService;
use App\Http\Controllers\Controller;
use Fenos\Notifynder\Facades\Notifynder;

/**
 * FOR REFACTOR:
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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("  businessId:%s businessSlug:'%s'", $business->id, $business->slug));

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $business_name = $business->name;
        Notifynder::category('user.visitedShowroom')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('business_name'))
                   ->send();

        $concierge = new ConciergeService(new VacancyService($business));
        $available = $concierge->isAvailable(auth()->user());

        return view('user.businesses.show', compact('business', 'available'));
    }

    /**
     * get List
     *
     * @return Response Rendered view of all existing Businesses
     */
    public function getList()
    {
        $this->log->info(__METHOD__);

        $businesses = Business::all();
        return view('user.businesses.index', compact('businesses'));
    }

    ////////////////
    // FOR REVIEW //
    ////////////////

    /**
     * Sets the selected business session var
     *
     * @param  Business $business Business to be selected
     * @return Response           Response provided by getHome()
     */
    public function getSelect(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("  businessId:%s", $business->id));

        session()->set('selected.business', $business);
        return $this->getHome($business);
    }

    /**
     * Gets the User profile Contacts that MAY BE subscribed to Businesses
     *
     * @return Response Rendered view of the Contacts linked to the requesting User
     */
    public function getSubscriptions()
    {
        $this->log->info(__METHOD__);

        $contacts = auth()->user()->contacts;
        return view('user.businesses.subscriptions', compact('contacts'));
    }
}
