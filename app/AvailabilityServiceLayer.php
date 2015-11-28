<?php

/**
 * ToDo: Should probably change name with design pattern suffix
 */

namespace App;

use App\Vacancy;
use App\Business;
use Carbon\Carbon;
use App\Appointment;
use Illuminate\Support\Collection;

class AvailabilityServiceLayer
{
    protected $business;

    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function getVacanciesFor($user, $limit = 7)
    {
        $appointments = $this->business->bookings()->future()->tillDate(Carbon::parse("today +$limit days"))->get();

        $vacancies = $this->getVacancies($limit);

        $vacancies = $this->removeSelfBooked($vacancies, $user);

        $starting = $this->business->pref('appointment_take_today') ? 'today' : 'tomorrow';
        $availability = $this->generateAvailability($vacancies, $starting, $limit);
        return $availability;
    }

    public function getVacancies($limit = 7)
    {
        $appointments = $this->business->bookings()->future()->tillDate(Carbon::parse("today +$limit days"))->get();

        $vacancies = $this->removeBookedVacancies($this->business->vacancies, $appointments);

        return $vacancies;
    }

    private function removeBookedVacancies(Collection $vacancies, Collection $appointments)
    {
        $vacancies = $vacancies->reject(function ($vacancy) {
            return $vacancy->isFull();
        });
        return $vacancies;
    }

    private function removeSelfBooked(Collection $vacancies, User $user)
    {
        $vacancies = $vacancies->reject(function ($vacancy) use ($user) {
            return $vacancy->isHoldingAnyFor($user);
        });
        return $vacancies;
    }

    public static function generateAvailability($vacancies, $starting = 'today', $days = 10)
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
            if ($vacancy->isHolding($appointment)) {
                return true;
            }
        }
        return false;
    }

    public function getSlotFor(Appointment $appointment)
    {
        $datetime = Carbon::parse($appointment->start_at);
        return $appointment->business->vacancies()
                                            ->forDateTime($datetime)
                                            ->forService($appointment->service)->first();
    }
}
