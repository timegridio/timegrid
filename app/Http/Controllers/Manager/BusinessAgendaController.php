<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Services\ConciergeService;

class BusinessAgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var App\Services\ConciergeService
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param App\Services\ConciergeService $concierge
     */
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
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);

        $appointments = $this->concierge->setBusiness($business)->getUnservedAppointments();

        $viewKey = 'manager.businesses.appointments.'.$business->strategy.'.index';

        return view($viewKey, compact('business', 'appointments'));
    }
}
