<?php

namespace App;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Business;
use App\AvailabilityServiceLayer;

class ConciergeServiceLayer
{
    private $availabilityService;

    public function __construct(AvailabilityServiceLayer $availabilityService = null)
    {
        $this->availabilityService = $availabilityService;
    }

    public function setAvailabilityService(AvailabilityServiceLayer $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * is available for at least one reservation
     *
     * @param  User     $user     Potential issuer of reservation
     * @param  integer  $limit    Quantiy of days from "today"
     * @return boolean            There exist vacancies to reserve
     */
    public function isAvailable(User $user, $limit = 7)
    {
        return $this->availabilityService->isAvailable($user, $limit);
    }

    /**
     * get Vacancies
     *
     * @param  User     $user     To present to User
     * @param  integer  $limit    For a maximum of $limit days
     * @return Array              Array of vacancies for each date
     */
    public function getVacancies(User $user, $limit = 7, $includeToday = false)
    {
        return $this->availabilityService->getVacanciesFor($user, $limit, $includeToday);
    }

    /**
     * get Appointments For
     *
     * @param  User   $user This User
     * @return Illuminate\Support\Collection       Collection of Appointments
     */
    public function getAppointmentsFor(User $user)
    {
        return $user->appointments()->orderBy('start_at')->get();
    }

    /**
     * make Reservation
     * @param  User     $issuer   Requested by User as issuer
     * @param  Business $business For Business
     * @param  Contact  $contact  On behalf of Contact
     * @param  Service  $service  For Service
     * @param  Carbon   $datetime     for Date and Time
     * @param  string   $comments     optional issuer comments for the appointment
     * @return Appointment|boolean             Generated Appointment or false
     */
    public function makeReservation(User $issuer, Business $business, Contact $contact, Service $service, Carbon $datetime, $comments = null)
    {
        $bookingStrategy = new BookingStrategy($business->strategy);

        $appointment = $bookingStrategy->generateAppointment($issuer, $business, $contact, $service, $datetime, $comments);

        if ($appointment->duplicates()) {
            return $appointment;
        }

        $vacancy = $this->availabilityService->getSlotFor($appointment->start_at, $appointment->service);

        if (null !== $vacancy) {
            if ($vacancy->hasRoom()) {
                $appointment->vacancy()->associate($vacancy);
                $appointment->save();

                return $appointment;
            }
        }
        return false;
    }
}
