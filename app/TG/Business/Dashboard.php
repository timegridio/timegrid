<?php

namespace App\TG\Business;

use Illuminate\Support\Collection;

class Dashboard
{
    private $business;

    private $time;

    protected $counter = [];

    const BOXES = [
        'appointments_active_today' => [
            'icon' => 'check',
            'color' => 'green',
            'title' => 'manager.businesses.dashboard.panel.title_appointments_active'
            ],
        'appointments_canceled_today' => [
            'icon' => 'minus-circle',
            'color' => 'red',
            'title' => 'manager.businesses.dashboard.panel.title_appointments_canceled'
            ],
        'appointments_active_tomorrow' => [
            'icon' => 'hourglass-o',
            'color' => 'yellow',
            'title' => 'manager.businesses.dashboard.panel.title_appointments_active'
            ],
        'contacts_subscribed' => [
            'icon' => 'users',
            'color' => 'green',
            'title' => 'manager.businesses.dashboard.panel.title_contacts_subscribed'
            ],
        'contacts_registered' => [
            'icon' => 'users',
            'color' => 'aqua',
            'title' => 'manager.businesses.dashboard.panel.title_contacts_registered'
            ],
        'appointments_total' => [
            'icon' => 'table',
            'color' => 'aqua',
            'title' => 'manager.businesses.dashboard.panel.title_appointments_total'
            ],
    ];

    public function __construct($business, $time)
    {
        $this->business = $business;

        $this->time = $time;

        $this->loadCounters();
    }

    protected function loadCounters()
    {
        // Build Dashboard Report
        $this->counter['appointments_active_today'] = $this->business->bookings()->active()->ofDate($this->time->today())->get()->count();
        $this->counter['appointments_canceled_today'] = $this->business->bookings()->canceled()->ofDate($this->time->today())->get()->count();
        $this->counter['appointments_active_tomorrow'] = $this->business->bookings()->active()->ofDate($this->time->tomorrow())->get()->count();
//        $this->counter['appointments_active_total'] = $this->business->bookings()->active()->get()->count();
//        $this->counter['appointments_served_total'] = $this->business->bookings()->served()->get()->count();
        $this->counter['appointments_total'] = $this->business->bookings()->get()->count();
        $this->counter['contacts_registered'] = $this->business->contacts()->count();
        $this->counter['contacts_subscribed'] = $this->business->contacts()->whereNotNull('user_id')->count();
    }

    public function getBoxes()
    {
        $bag = new Collection;

        foreach (self::BOXES as $key => $boxParameters) {
            $boxParameters['number'] = $this->counter[$key];
            $bag->push($boxParameters);
        }

        return $bag;
    }


}
