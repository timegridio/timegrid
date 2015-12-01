<?php

namespace App\Http\Controllers\Guest;

use App\Models\Business;
use App\Http\Controllers\Controller;

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
        $this->log->info(sprintf("  businessId:%s businessSlug:%s", 
                                    $business->id,
                                    $business->slug
                                ));

        return view('guest.businesses.show', compact('business'));
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
        return view('guest.businesses.index', compact('businesses'));
    }
}
