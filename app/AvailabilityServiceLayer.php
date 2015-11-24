<?php

/**
 * ToDo: Should probably change name with design pattern suffix
 */

namespace App;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Business;
use App\Appointment;
use App\Vacancy;

class AvailabilityServiceLayer
{
    protected $business;

    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function getVacancies($limit = 7)
    {
        $appointments = $this->business->bookings()->future()->tillDate(Carbon::parse("today +$limit days"))->get();
        $vacancies = $this->removeBookedVacancies($this->business->vacancies, $appointments);
         /* ToDo: Review, self bookings should be already filtered from the general appointments (above) */
        # $vacancies = $this->removeSelfBooked($vacancies, $user->appointments);
        $starting = $this->business->pref('appointment_take_today') ? 'today' : 'tomorrow';
        $availability = $this->generateAvailability($vacancies, $starting, $limit);
        return $availability;
    }

    private function removeBookedVacancies(Collection $vacancies, Collection $appointments)
    {
        $vacancies = $vacancies->reject(function ($vacancy) use ($appointments) {
            return $vacancy->isFull($appointments);
        });
        return $vacancies;
    }

/* Obsolete, for review */
#    private function removeSelfBooked(Collection $vacancies, Collection $appointments)
#    {
#        $vacancies = $vacancies->reject(function ($vacancy) use ($appointments) {
#        if ($vacancy->holdsAnyAppointment($appointments)) {
#            return true;
#        }
#        });
#        return $vacancies;
#    }

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

    public function isSlotAvailable(Appointment $appointment)
    {
        $vacancies = $appointment->business->vacancies()->forDate(Carbon::parse($appointment->date, $appointment->business->timezone))->forService($appointment->service)->get();
        $vacancies = $this->removeBookedVacancies($vacancies, $appointment->business->bookings()->get());
        foreach ($vacancies as $vacancy) {
            if ($vacancy->holdsAppointment($appointment)) {
                return true;
            }
        }
        return false;
    }
}
