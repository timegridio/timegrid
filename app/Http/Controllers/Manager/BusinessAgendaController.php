<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Concierge;

class BusinessAgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Alfred
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param Timegridio\Concierge\Alfred $concierge
     */
    public function __construct(Concierge $concierge)
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
