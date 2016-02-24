<?php

namespace App;

use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use Timegridio\Concierge\Models\Service;
use App\Models\User;
use Timegridio\Concierge\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface BookingStrategyInterface
{
    public function generateAppointment(
        User $issuer,
        Business $business,
        Contact $contact,
        Service $service,
        Carbon $datetime,
        $comments = null
    );

    public function hasRoom(Appointment $appointment, Vacancy $vacancy);

    public function removeBookedVacancies(Collection $vacancies);

    public function removeSelfBooked(Collection $vacancies, User $user);
}
