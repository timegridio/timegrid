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
    /**
     * is available for at least one reservation
     *
     * @param  Business $business Inquiry business
     * @param  User     $user     Potential issuer of reservation
     * @param  integer  $limit    Quantiy of days from "today"
     * @return boolean            There exist vacancies to reserve
     */
    public function isAvailable(Business $business, User $user, $limit = 7)
    {
        $availability = new AvailabilityServiceLayer($business);

        return $availability->isAvailable($user, $limit);
    }

    /**
     * get Vacancies
     *
     * @param  Business $business For desired Business
     * @param  User     $user     To present to User
     * @param  integer  $limit    For a maximum of $limit days
     * @return Array              Array of vacancies for each date
     */
    public function getVacancies(Business $business, User $user, $limit = 7)
    {
        $availability = new AvailabilityServiceLayer($business);

        return $availability->getVacanciesFor($user, $limit);
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

        $availability = new AvailabilityServiceLayer($business);

        $vacancy = $availability->getSlotFor($appointment);

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
