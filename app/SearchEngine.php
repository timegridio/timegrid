<?php

namespace App;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\User;
use App\Business;
use App\Contact;
use App\Appointment;

class SearchEngine
{
    protected $results = [];

    protected $scope = [];

    public function __construct($expression)
    {
        $this->scope['businessesIds'] = \Auth::user()->businesses->transform(function($item, $key){ return $item->id; });
        
        $this->search($expression);
    }

    public function search($expression)
    {
        if (strlen($expression) < 3) return false;

        $this->getAppointments($expression);
        $this->getContacts($expression);
        $this->getServices($expression);
    }

    public function results()
    {
        return $this->results;
    }

    private function getServices($expression)
    {
        $this->results['services'] = Service::whereIn('business_id', $this->scope['businessesIds'])->where('name', 'like', $expression.'%')->get();
    }

    private function getAppointments($expression)
    {
        $this->results['appointments'] = Appointment::whereIn('business_id', $this->scope['businessesIds'])->where('hash', 'like', $expression.'%')->get();
    }

    private function getContacts($expression)
    {
        $businesses = Business::whereIn('id', $this->scope['businessesIds'])->get();
        foreach ($businesses as $business) {
            $collection = $business->contacts()->where(function($query) use($expression){
                $query->where('lastname', 'like', $expression.'%')
                      ->orWhere('firstname', 'like', $expression.'%')
                      ->orWhere('nin', $expression)
                      ->orWhere('mobile', 'like', '%'.$expression);
            })->get();
            $this->results['contacts'] = $collection;
        }
    }
}
