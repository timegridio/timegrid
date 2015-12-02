<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\Service;
use App\Models\Business;
use App\Models\Appointment;
use Illuminate\Support\Collection;

class VacancyService
{
    protected $business;

    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    public function setBusiness(Business $business)
    {
        $this->business = $business;
    }

    public function isAvailable(User $user, $limit = 7)
    {
        $vacancies = $this->getVacancies($limit);
        $vacancies = $this->removeSelfBooked($vacancies, $user);

        return !$vacancies->isEmpty();
    }

    public function getVacanciesFor($user, $limit = 7, $includeToday = true)
    {
        $vacancies = $this->getVacancies($limit);

        $vacancies = $this->removeSelfBooked($vacancies, $user);

        $starting = $includeToday ? 'today' : 'tomorrow';
        $availability = $this->generateAvailability($vacancies, $starting, $limit);
        return $availability;
    }

    public function getVacancies($limit = 7)
    {
        $appointments = $this->business->bookings()->future()->tillDate(Carbon::parse("today +$limit days"))->get();

        $vacancies = $this->removeBookedVacancies($this->business->vacancies);

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

    public function getSlotFor(Carbon $targetDateTime, Service $service)
    {
        return $this->business->vacancies()->forDateTime($targetDateTime)
                                            ->forService($service)
                                            ->first();
    }

    /////////////
    // HELPERS //
    /////////////

    private function removeBookedVacancies(Collection $vacancies)
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
}
