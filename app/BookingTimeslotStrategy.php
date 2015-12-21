<?php

namespace App;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingTimeslotStrategy implements BookingStrategyInterface
{
    public function generateAppointment(
        User $issuer,
        Business $business,
        Contact $contact,
        Service $service,
        Carbon $datetime,
        $comments = null
    ) {
        $appointment = new Appointment();

        $appointment->doReserve();
        $appointment->setStartAtAttribute($datetime);
        $appointment->setFinishAtAttribute($datetime->copy()->addMinutes($service->duration));
        $appointment->duration = $service->duration;
        $appointment->business()->associate($business);
        $appointment->issuer()->associate($issuer);
        $appointment->contact()->associate($contact);
        $appointment->service()->associate($service);
        $appointment->comments = $comments;
        $appointment->doHash();

        return $appointment;
    }

    public function hasRoom(Appointment $appointment, Vacancy $vacancy)
    {
        return $vacancy->hasRoomBetween($appointment->start_at, $appointment->finish_at);
    }

    /**
     * [removeBookedVacancies description].
     *
     * @param Collection $vacancies
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function removeBookedVacancies(Collection $vacancies)
    {
        #$vacancies = $vacancies->reject(function ($vacancy) {
        #    return $vacancy->isFull();
        #});

        return $vacancies;
    }

    /**
     * [removeBookedVacancies description].
     *
     * @param Collection $vacancies
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function removeSelfBooked(Collection $vacancies, User $user)
    {
        #$vacancies = $vacancies->reject(function ($vacancy) use ($user) {
        #    return $vacancy->isHoldingAnyFor($user);
        #});

        return $vacancies;
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
        $dates = [];
        for ($i = 0; $i < $days; $i++) {
            $dates[date('Y-m-d', strtotime("$starting +$i days"))] = [];
        }

        foreach ($vacancies as $vacancy) {
            if (array_key_exists($vacancy->date, $dates)) {
                $dates[$vacancy->date][$vacancy->service->slug] = $this->chunkTimeslots($vacancy);
            }
        }

        return $dates;
    }

    protected function chunkTimeslots(Vacancy $vacancy, $step = 30)
    {
        $times = [];
        $startTime = $vacancy->business->pref('start_at');

        $startKey = date('Y-m-d H:i', strtotime("{$vacancy->date} {$startTime}")).' '.$vacancy->business->timezone;

        $finishTime = $vacancy->business->pref('finish_at');
        $endKey = date('Y-m-d H:i', strtotime("{$vacancy->date} {$finishTime}")).' '.$vacancy->business->timezone;

        $fromTime = Carbon::parse($startKey);
        $toTime = $fromTime->copy()->addMinutes($step);
        $limit = Carbon::parse($endKey);

        while ($fromTime <= $limit) {
            $times[$fromTime->timezone($vacancy->business->timezone)->toTimeString()] = $vacancy->getRoomBetween($fromTime, $toTime);
            $toTime->addMinutes($step);
            $fromTime->addMinutes($step);
        }

        return $times;
    }
}
