<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VacancyService
{
    /**
     * Business to operate on.
     *
     * @var App\Models\Business
     */
    protected $business;

    /**
     * Create the Vacancy Service object.
     *
     * @param App\Models\Business $business
     */
    public function __construct(Business $business)
    {
        $this->setBusiness($business);
    }

    /**
     * Set Business.
     *
     * @param App\Models\Business $business
     */
    public function setBusiness(Business $business)
    {
        $this->business = $business;
    }

    /**
     * [isAvailable description].
     *
     * @param  User    $user
     * @return boolean
     */
    public function isAvailable(User $user)
    {
        $vacancies = $this->removeBookedVacancies($this->business->vacancies);
        $vacancies = $this->removeSelfBooked($vacancies, $user);

        return !$vacancies->isEmpty();
    }

    /**
     * [getVacanciesFor description].
     *
     * @param  App\Models\User  $user
     * @param  string           $starting
     * @param  integer          $limit
     *
     * @return array
     */
    public function getVacanciesFor($user, $starting = 'today', $limit = 7)
    {
        $vacancies = $this->removeBookedVacancies($this->business->vacancies);
        $vacancies = $this->removeSelfBooked($vacancies, $user);

        return $this->generateAvailability($vacancies, $starting, $limit);
    }

    /**
     * [generateAvailability description].
     *
     * @param  Illuminate\Database\Eloquent\Collection  $vacancies
     * @param  string                                   $starting
     * @param  integer                                  $days
     *
     * @return array
     */
    public static function generateAvailability($vacancies, $starting = 'today', $days = 10)
    {
        $dates = [];
        for ($i = 0; $i < $days; $i++) {
            $dates[date('Y-m-d', strtotime("$starting +$i days"))] = [];
        }

        foreach ($vacancies as $vacancy) {
            if (array_key_exists($vacancy->date, $dates)) {
                $dates[$vacancy->date][$vacancy->service->slug] = $vacancy;
            }
        }

        return $dates;
    }

    /**
     * Get a Vacancy for a given DateTime and Service combination.
     *
     * @param  Carbon  $targetDateTime
     * @param  Service $service
     *
     * @return App\Models\Vacancy
     */
    public function getSlotFor(Carbon $targetDateTime, Service $service)
    {
        return $this->business
            ->vacancies()
            ->forDateTime($targetDateTime)
            ->forService($service)
            ->first();
    }

    /**
     * Update vacancies.
     *
     * @param  Business $business
     * @param  array    $dates
     *
     * @return bool
     */
    public function update(Business $business, $dates)
    {
        $changed = false;
        foreach ($dates as $date => $vacancy) {
            foreach ($vacancy as $serviceId => $capacity) {
                switch (trim($capacity)) {
                    case '':
                        // Dont update, leave as is
                        logger()->info(sprintf('businessId:%s %s: Blank vacancy capacity value', $business->id, $date));
                        break;
                    default:
                        $startAt = Carbon::parse($date.' '.$business->pref('start_at').' '.$business->timezone);
                        $finishAt = Carbon::parse($date.' '.$business->pref('finish_at').' '.$business->timezone);

                        $vacancyKeys = [
                            'business_id' => $business->id,
                            'service_id'  => $serviceId,
                            'date'        => $date,
                            ];

                        $vacancyValues = [
                            'capacity'  => intval($capacity),
                            'start_at'  => $startAt,
                            'finish_at' => $finishAt,
                            ];

                        $vacancy = Vacancy::updateOrCreate($vacancyKeys, $vacancyValues);

                        $changed = true;
                        break;
                }
            }
        }

        return $changed;
    }

    /////////////
    // HELPERS //
    /////////////

    /**
     * [removeBookedVacancies description].
     *
     * @param  Collection $vacancies
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function removeBookedVacancies(Collection $vacancies)
    {
        $vacancies = $vacancies->reject(function ($vacancy) {
            return $vacancy->isFull();
        });

        return $vacancies;
    }

    /**
     * [removeBookedVacancies description].
     *
     * @param  Collection $vacancies
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function removeSelfBooked(Collection $vacancies, User $user)
    {
        $vacancies = $vacancies->reject(function ($vacancy) use ($user) {
            return $vacancy->isHoldingAnyFor($user);
        });

        return $vacancies;
    }
}
