<?php

namespace App;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\User;
use App\Business;
use App\Contact;
use App\Appointment;
use App\Service;
use App\Vacancy;

class ConciergeStrategy
{
    public static function getVacancies(Business $business, Carbon $date, User $user, $limit = 7)
    {
        $appointments = $business->bookings()->future()->tillDate(Carbon::parse("today +$limit days"))->get();
        $vacancies = self::removeBooked($business->vacancies, $appointments);
        $vacancies = self::removeSelfBooked($vacancies, $user->appointments);
        $availability = self::generateAvailability($vacancies, $limit);
        return $availability;
    }

    public static function generateAvailability($vacancies, $days = 10)
    {
        $dates = [];
        for ($i=0; $i < $days; $i++) {
            $dates[date('Y-m-d', strtotime("today +$i days"))] = [];
        }
        foreach ($vacancies as $key => $vacancy) {
            if (array_key_exists($vacancy->date, $dates)) {
                $dates[$vacancy->date][$vacancy->service->slug] = $vacancy;
            }
        }
        return $dates;
    }

    public static function removeBooked(Collection $vacancies, Collection $appointments)
    {
        $vacancies = $vacancies->reject(function ($vacancy) use ($appointments) {
            if ($vacancy->isFull($appointments)) {
                return true;
            }
        });
        return $vacancies;
    }

    public static function removeSelfBooked(Collection $vacancies, Collection $appointments)
    {
        $vacancies = $vacancies->reject(function ($vacancy) use ($appointments) {
            if ($vacancy->holdsAnyAppointment($appointments)) {
                return true;
            }
        });
        return $vacancies;
    }
}
