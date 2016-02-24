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

class BookingStrategy
{
    protected $strategy = null;

    public function __construct($strategyId)
    {
        info("BookingStrategy: Using {$strategyId}");
        switch ($strategyId) {
            case 'timeslot':
                $this->strategy = new BookingTimeslotStrategy();
                break;
            case 'dateslot':
                $this->strategy = new BookingDateslotStrategy();
                break;
            default:
                logger("BookingStrategy: __construct: Illegal strategy:{$strategyId}");
                break;
        }
    }

    public function generateAppointment(
        User $issuer,
        Business $business,
        Contact $contact,
        Service $service,
        Carbon $datetime,
        $comments = null
    ) {
        return $this->strategy->generateAppointment($issuer, $business, $contact, $service, $datetime, $comments);
    }

    public function hasRoom(Appointment $appointment, Vacancy $vacancy)
    {
        return $this->strategy->hasRoom($appointment, $vacancy);
    }

    public function removeBookedVacancies(Collection $vacancies)
    {
        return $this->strategy->removeBookedVacancies($vacancies);
    }

    public function removeSelfBooked(Collection $vacancies, User $user)
    {
        return $this->strategy->removeSelfBooked($vacancies, $user);
    }

    public function buildTimetable($vacancies, $starting = 'today', $days = 10)
    {
        return $this->strategy->buildTimetable($vacancies, $starting, $days);
    }
}
