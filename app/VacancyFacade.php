<?php

/**
 * ToDo: Should probably change name with design pattern suffix
 */

namespace App;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Business;

class VacancyFacade
{
    protected $business;

    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function getVacancies($limit = 7)
    {
        $appointments = $this->business->bookings()->future()->tillDate(Carbon::parse("today +$limit days"))->get();
        $vacancies = $this->removeBooked($this->business->vacancies, $appointments);        
        #$vacancies = $this->removeSelfBooked($vacancies, $user->appointments);/* Self bookings should be included in the general appointments */
        $starting = $this->business->pref('appointment_take_today') ? 'today' : 'tomorrow';
        $availability = $this->generateAvailability($vacancies, $starting, $limit);
        return $availability;
    }

    private function removeBooked(Collection $vacancies, Collection $appointments)
    {
        $vacancies = $vacancies->reject(function ($vacancy) use ($appointments) {
            if ($vacancy->isFull($appointments)) {
                return true;
            }
        });
        return $vacancies;
    }

    private function generateAvailability($vacancies, $starting = 'today', $days = 10)
    {
        $dates = [];
        for ($i=0; $i < $days; $i++) {
            $dates[date('Y-m-d', strtotime("$starting +$i days"))] = [];
        }
        foreach ($vacancies as $vacancy) {
            if (array_key_exists($vacancy->date, $dates)) {
                $dates[$vacancy->date][$vacancy->service->slug] = $vacancy;
            }
        }
        return $dates;
    }
}
