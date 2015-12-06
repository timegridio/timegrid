<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Business;

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
        $this->log->info(sprintf('businessId:%s businessSlug:%s', $business->id, $business->slug));

        return view('guest.businesses.show', compact('business'));
    }
}
