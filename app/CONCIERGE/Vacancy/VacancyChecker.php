<?php

namespace Concierge\Vacancy;

use Concierge\Booking\Strategies\BookingStrategy;
use App\Models\Vacancy;
use Carbon\Carbon;

class VacancyChecker
{
    protected $business;

    protected $strategy;

    public function __construct()
    {
        // $this->setBusiness($business);
    }

    public function setStrategy($strategy)
    {
        $this->strategy = new BookingStrategy($strategy);

        return $this;
    }

    public function isAvailable(User $user)
    {
        $vacancies = $this->strategy->removeBookedVacancies($this->vacancies);
        $vacancies = $this->strategy->removeSelfBooked($vacancies, $user);

        return !$vacancies->isEmpty();
    }

    public function getVacanciesFor($user, $starting = 'today', $limit = 7)
    {
        $vacancies = $this->strategy->removeBookedVacancies($this->vacancies);
        $vacancies = $this->strategy->removeSelfBooked($vacancies, $user);

        return $this->generateAvailability($vacancies, $starting, $limit);
    }
}
