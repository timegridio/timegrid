<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;

class BusinessAgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param Timegridio\Concierge\Concierge
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

        $appointments = $this->concierge->business($business)->getUnservedAppointments();

        $viewKey = count($appointments) == 0
            ? 'manager.businesses.appointments.empty'
            : 'manager.businesses.appointments.'.$business->strategy.'.index';

        return view($viewKey, compact('business', 'appointments'));
    }
}
