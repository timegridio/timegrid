<?php

namespace App\Services;

use App\BookingStrategy;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

/*******************************************************************************
 * Concierge Service Layer
 *     High level booking manager
 ******************************************************************************/
class ConciergeService
{
    /**
     * [$vacancyService description].
     *
     * @var [type]
     */
    private $vacancyService;

    private $business;

    /**
     * [__construct description].
     *
     * @param VacancyService|null $vacancyService [description]
     */
    public function __construct(VacancyService $vacancyService = null)
    {
        $this->vacancyService = $vacancyService;
    }

#    /**
#     * [setVacancyService description]
#     *
#     * @param VacancyService $vacancyService [description]
#     */
#    public function setVacancyService(VacancyService $vacancyService)
#    {
#        $this->vacancyService = $vacancyService;
#    }

    public function setBusiness(Business $business)
    {
        $this->business = $business;

        $this->vacancyService->setBusiness($business);

        return $this;
    }

    /**
     * is available for at least one reservation.
     *
     * @param User $user  Potential issuer of reservation
     * @param int  $limit Quantiy of days from "today"
     *
     * @return bool There exist vacancies to reserve
     */
    public function isAvailable(User $user, $limit = 7)
    {
        return $this->vacancyService->isAvailable($user, $limit);
    }

    public function getUnservedAppointments()
    {
        return $appointments = $this->business
            ->bookings()->with('contact')
            ->with('business')
            ->with('service')
            ->unserved()
            ->orderBy('start_at')
            ->get();
    }

    /**
     * get Vacancies.
     *
     * @param User $user  To present to User
     * @param int  $limit For a maximum of $limit days
     *
     * @return array Array of vacancies for each date
     */
    public function getVacancies(User $user, $starting = 'today', $limit = 7)
    {
        return $this->vacancyService->getVacanciesFor($user, $starting, $limit);
    }

#    /**
#     * get Appointments For
#     *
#     * @param  User   $user This User
#     * @return Illuminate\Support\Collection       Collection of Appointments
#     */
#    public function getAppointmentsFor(User $user)
#    {
#        return $user->appointments()->orderBy('start_at')->get();
#    }

#    /**
#     * get Future Appointments For
#     *
#     * @param  User   $user This User
#     * @return Illuminate\Support\Collection       Collection of Appointments
#     */
#    public function getFutureAppointmentsFor(User $user)
#    {
#        return $user->appointments()->orderBy('start_at')->future()->get();
#    }

#    /**
#     * get Active Appointments For
#     *
#     * @param  User   $user This User
#     * @return Illuminate\Support\Collection       Collection of Appointments
#     */
#    public function getActiveAppointmentsFor(User $user)
#    {
#        return $user->appointments()->orderBy('start_at')->active()->get();
#    }

    /**
     * get Unarchived Appointments For.
     *
     * @param User $user This User
     *
     * @return Illuminate\Support\Collection Collection of Appointments
     */
    public function getUnarchivedAppointmentsFor(User $user)
    {
        return $user->appointments()->orderBy('start_at')->unarchived()->get();
    }

    /**
     * make Reservation.
     *
     * @param User     $issuer   Requested by User as issuer
     * @param Business $business For Business
     * @param Contact  $contact  On behalf of Contact
     * @param Service  $service  For Service
     * @param Carbon   $datetime for Date and Time
     * @param string   $comments optional issuer comments for the appointment
     *
     * @return Appointment|bool Generated Appointment or false
     */
    public function makeReservation(User $issuer, Business $business, Contact $contact, Service $service, Carbon $datetime, $comments = null)
    {
        //////////////////
        // FOR REFACTOR //
        //////////////////

        $this->setBusiness($business);

        $bookingStrategy = new BookingStrategy($business->strategy);

        $appointment = $bookingStrategy->generateAppointment(
            $issuer,
            $business,
            $contact,
            $service,
            $datetime,
            $comments
        );

        if ($appointment->duplicates()) {
            throw new AppointmentDuplicationException;
        }

        $vacancy = $this->vacancyService->getSlotFor($appointment->start_at, $appointment->service);

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
