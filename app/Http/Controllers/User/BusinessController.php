<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Services\ConciergeService;
use App\Services\VacancyService;
use Fenos\Notifynder\Facades\Notifynder;

/**
 * FOR REFACTOR:
 *     - Access Notifynder with constructor dependency injection
 *     - Access Auth with constructor dependency injection
 *     - Access Business with dependency injection of a BusinessRepository.
 */
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
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("businessId:%s businessSlug:'%s'", $business->id, $business->slug));

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $businessName = $business->name;
        Notifynder::category('user.visitedShowroom')
                   ->from('App\Models\User', auth()->user()->id)
                   ->to('App\Models\Business', $business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName'))
                   ->send();

        $concierge = new ConciergeService(new VacancyService($business));
        #$available = $concierge->isAvailable(auth()->user());
        $concierge->setBusiness($business);

        $appointment = $concierge->getNextAppointmentFor(auth()->user()->contacts);

        $available = true;

        return view('user.businesses.show', compact('business', 'available', 'appointment'));
    }

    /**
     * get List.
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
     * Gets the User profile Contacts that MAY BE subscribed to Businesses.
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
