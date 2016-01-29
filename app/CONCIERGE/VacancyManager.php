<?php

namespace Concierge;

use App\Models\Business;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Concierge\Booking\Strategies\BookingStrategy;

class VacancyManager
{
    /**
     * Business to operate on.
     *
     * @var App\Models\Business
     */
    protected $business;

    /**
     * Booking strategy.
     *
     * @var BookingStrategy
     */
    protected $strategy;

    /**
     * Create the Vacancy Service object.
     *
     * @param App\Models\Business $business
     */
    public function __construct()
    {
        // $this->setBusiness($business);
    }

    /**
     * Set Business.
     *
     * @param App\Models\Business $business
     */
    public function setBusiness(Business $business)
    {
        $this->business = $business;

        $this->strategy = new BookingStrategy($business->strategy);

        return $this;
    }

    /**
     * [isAvailable description].
     *
     * @param User $user
     *
     * @return bool
     */
    public function isAvailable(User $user)
    {
        $vacancies = $this->strategy->removeBookedVacancies($this->business->vacancies);
        $vacancies = $this->strategy->removeSelfBooked($vacancies, $user);

        return !$vacancies->isEmpty();
    }

    /**
     * [getVacanciesFor description].
     *
     * @param App\Models\User $user
     * @param string          $starting
     * @param int             $limit
     *
     * @return array
     */
    public function getVacanciesFor($user, $starting = 'today', $limit = 7)
    {
        $vacancies = $this->strategy->removeBookedVacancies($this->business->vacancies);
        $vacancies = $this->strategy->removeSelfBooked($vacancies, $user);

        return $this->generateAvailability($vacancies, $starting, $limit);
    }

    /**
     * Build timetable.
     *
     * @param Illuminate\Database\Eloquent\Collection $vacancies
     * @param string                                  $starting
     * @param int                                     $days
     *
     * @return array
     */
    public function buildTimetable($vacancies, $starting = 'today', $days = 10)
    {
        return $this->strategy->buildTimetable($vacancies, $starting, $days);
    }

    /**
     * [generateAvailability description].
     *
     * @param Illuminate\Database\Eloquent\Collection $vacancies
     * @param string                                  $starting
     * @param int                                     $days
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
     * @param Carbon  $targetDateTime
     * @param int  $serviceId
     *
     * @return App\Models\Vacancy
     */
    public function getSlotFor(Carbon $targetDateTime, $serviceId)
    {
        return $this->business
            ->vacancies()
            ->forDateTime($targetDateTime)
            ->forService($serviceId)
            ->first();
    }

    /**
     * Update vacancies.
     *
     * @param Business $business
     * @param array    $dates
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
                        $startAt = Carbon::parse($date.' '.$business->pref('start_at').' '.$business->timezone)->timezone('UTC');
                        $finishAt = Carbon::parse($date.' '.$business->pref('finish_at').' '.$business->timezone)->timezone('UTC');

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

    /**
     * Update vacancies from batch statements.
     *
     * @param Business $business
     * @param array    $parsedStatements
     *
     * @return bool
     */
    public function updateBatch(Business $business, $parsedStatements)
    {
        $changed = false;
        $dates = $this->arrayGroupBy('date', $parsedStatements);

        foreach ($dates as $date => $statements) {
            $services = $this->arrayGroupBy('service', $statements);

            $changed |= $this->processServiceStatements($business, $date, $services);
        }

        return $changed;
    }

    protected function processServiceStatements($business, $date, $services)
    {
        $changed = false;
        foreach ($services as $serviceSlug => $statements) {
            $service = Service::where('slug', $serviceSlug)->get()->first();

            if ($service === null) {

                //  Invalid services are skipped to avoid user frustration.
                //  TODO: Still, a user-level WARNING should be raised with no fatal error

                continue;
            }

            $vacancy = $business->vacancies()->forDate(Carbon::parse($date))->forService($service);

            if ($vacancy) {
                $vacancy->delete();
            }

            $changed |= $this->processStatements($business, $date, $service, $statements);
        }

        return $changed;
    }

    protected function processStatements($business, $date, $service, $statements)
    {
        $changed = false;
        foreach ($statements as $statement) {
            $changed |= $this->publishVacancy($business, $date, $service, $statement);
        }

        return $changed;
    }

    protected function publishVacancy($business, $date, $service, $statement)
    {
        $date = $statement['date'];
        $startAt = $statement['startAt'];
        $finishAt = $statement['finishAt'];

        $startAt = Carbon::parse("{$date} {$startAt} {$business->timezone}")->timezone('UTC');
        $finishAt = Carbon::parse("{$date} {$finishAt} {$business->timezone}")->timezone('UTC');

        $vacancyValues = [
            'business_id' => $business->id,
            'service_id'  => $service->id,
            'date'        => $statement['date'],
            'capacity'    => intval($statement['capacity']),
            'start_at'    => $startAt,
            'finish_at'   => $finishAt,
            ];

        $vacancy = Vacancy::create($vacancyValues);

        return $vacancy !== null;
    }

    protected function arrayGroupBy($key, $array)
    {
        $grouped = [];
        foreach ($array as $hash => $item) {
            if (!array_key_exists($item[$key], $grouped)) {
                $grouped[$item[$key]] = [];
            }
            $grouped[$item[$key]][] = $item;
        }

        return $grouped;
    }
}
