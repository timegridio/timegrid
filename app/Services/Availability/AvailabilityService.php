<?php

namespace App\Services\Availability;

use Carbon\Carbon;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Service;
use Timegridio\Concierge\Models\Vacancy;

class AvailabilityService
{
    protected $timezone;

    protected $timeformat = 'H:i';

    protected $excludeDates = [];

    public function timezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function timeformat($timeformat)
    {
        $this->timeformat = $timeformat;

        return $this;
    }

    public function excludeDates($dates)
    {
        $this->excludeDates = $dates;

        return $this;
    }

    public function getDates(Business $business, $serviceId)
    {
        $vacancies = $business->vacancies()->forService($serviceId)->get();

        $vacancies = $this->removeExcludedDates($vacancies);

        $dates = array_pluck($vacancies->toArray(), 'date');

        return array_diff($dates, $this->excludeDates);
    }

    protected function removeExcludedDates($vacancies)
    {
        $excludedDates = collect($this->excludeDates);

        return $vacancies->reject(function ($vacancy) use ($excludedDates) {

            return $excludedDates->contains("{$vacancy->humanresourceSlug()}:{$vacancy->date}") ||
                   $excludedDates->contains("{$vacancy->date}");
        });
    }

    public function getTimes(Business $business, Service $service, Carbon $date)
    {
        $vacancies = $business->vacancies()->forService($service->id)->forDate($date)->get();

        $step = $this->calculateStep($business, $service->duration);

        return $this->splitTimes($vacancies, $service, $step);
    }

    protected function splitTimes($vacancies, $service, $step = 30)
    {
        $times = [];
        foreach ($vacancies as $vacancy) {
            $beginTime = $vacancy->start_at->copy();

            $maxNumberOfSlots = round($vacancy->finish_at->diffInMinutes($beginTime) / $step);

            $this->addSlots($times, $vacancy, $beginTime, $service->duration, $step, $maxNumberOfSlots);
        }

        return $times;
    }

    protected function addSlots(array &$times, Vacancy $vacancy, Carbon $beginTime, $duration, $step, $maxNumberOfSlots)
    {
        for ($i = 0; $i <= $maxNumberOfSlots; $i++) {
            $serviceEndTime = $beginTime->copy()->addMinutes($duration);

            if ($vacancy->hasRoomBetween($beginTime, $serviceEndTime)) {
                $times[] = $beginTime->timezone($this->timezone)->format($this->timeformat);
            }

            $beginTime->addMinutes($step);
        }
    }

    protected function calculateStep(Business $business, $defaultStep = 30)
    {
        $step = $business->pref('timeslot_step');

        if (0 != $step) {
            return $step;
        }

        return $defaultStep;
    }
}
