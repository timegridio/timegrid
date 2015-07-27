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
    /**
     * TODO: Check if there is a suitable package for seaching among Models
     */

    protected $results = [];

    protected $scope = [];

    protected $criteria = '';

    public function __construct($criteria)
    {
        $this->scope['businessesIds'] = \Auth::user()->businesses->transform(function($item, $key){ return $item->id; });
        $this->criteria = $criteria;
    }

    public function setBusinessScope(Array $scope)
    {
        $this->scope['businessesIds'] = $scope;
        return $this;
    }

    public function run()
    {
        if (strlen($this->criteria) < 3) return false;

        $this->getAppointments($this->criteria);
        $this->getContacts($this->criteria);
        $this->getServices($this->criteria);

        return $this;
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
