<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Domain;

class BusinessController extends Controller
{
    /**
     * get Home.
     *
     * @param Business $business Business to display
     *
     * @return Response Rendered view for desired Business
     */
    public function getHome($slug)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('slug:%s', $slug));

        if ($domain = Domain::where('slug', $slug)->first()) {
            return $this->getDomain($domain);
        }

        if ($business = Business::where('slug', $slug)->first()) {
            session()->set('guest.last-intended-business-home', $slug);

            return view('guest.businesses.show', compact('business'));
        }

        session()->forget('guest.last-intended-business-home');

        $baseurl = url()->to('/'.$slug);

        flash()->success(trans('app.msg.slug_is_available', compact('baseurl')));

        return redirect()->to('/login');
    }

    /**
     * get Domain.
     *
     * @return Response Rendered view of all existing Businesses belonging to Domain
     */
    public function getDomain(Domain $domain)
    {
        logger()->info(__METHOD__);

        $businesses = $domain->businesses;

        if (1 == $businesses->count()) {
            return redirect(route('guest.business.home', $businesses->first()));
        }

        return view('guest.businesses.index', compact('businesses'));
    }
}
