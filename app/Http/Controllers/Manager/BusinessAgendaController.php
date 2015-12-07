<?php

namespace App\Http\Controllers\Manager;

use App\Models\Business;
use App\Services\ConciergeService;
use App\Http\Controllers\Controller;

class BusinessAgendaController extends Controller
{
    private $concierge;

    public function __construct(ConciergeService $concierge)
    {
        $this->concierge = $concierge;

        parent::__construct();
    }

    /**
     * get Index.
     *
     * @param Business $business Business to get agenda
     *
     * @return Response Rendered view of Business agenda
     */
    public function getIndex(Business $business)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);
        
        $appointments = $this->concierge->setBusiness($business)->getUnservedAppointments();

        $viewKey = 'manager.businesses.appointments.'.$business->strategy.'.index';
        return view($viewKey, compact('business', 'appointments'));
    }
}
