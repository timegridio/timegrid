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
}
