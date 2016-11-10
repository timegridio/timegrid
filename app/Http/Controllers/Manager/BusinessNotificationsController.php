<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Fenos\Notifynder\Facades\Notifynder;
use Timegridio\Concierge\Models\Business;

class BusinessNotificationsController extends Controller
{
    /**
     * Show Business Notifications.
     *
     * @param Business            $business Business to show
     *
     * @return Response Rendered view for Business show
     */
    public function show(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);

        // BEGIN
        $notifications = Notifynder::entity(Business::class)->getAll($business->id);

        return view('manager.businesses.notifications', compact('business', 'notifications'));
    }
}
