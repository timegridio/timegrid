<?php

namespace App\Services;

use App\BookingStrategy;
use App\Events\AppointmentWasConfirmed;
use App\Models\Appointment;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Fenos\Notifynder\Facades\Notifynder;

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
        return $this->business
            ->bookings()->with('contact')
            ->with('business')
            ->with('service')
            ->unserved()
            ->orderBy('start_at')
            ->get();
    }

    public function getActiveAppointments()
    {
        return $this->business
            ->bookings()->with('contact')
            ->with('business')
            ->with('service')
            ->active()
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
     * get Next Appointment For Cintacts.
     *
     * @param $contacts
     *
     * @return App\Models\Appointment|null
     */
    public function getNextAppointmentFor($contacts)
    {
        return $this->business->bookings()->forContacts($contacts)->active()->first();
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
            return $appointment;
            // throw new \Exception('Duplicated Appointment Attempted');
        }

        $vacancy = $this->vacancyService->getSlotFor($appointment->start_at, $appointment->service->id);

        if ($vacancy != null && $bookingStrategy->hasRoom($appointment, $vacancy)) {
            $appointment->vacancy()->associate($vacancy);
            $appointment->save();

            return $appointment;
        }

        return false;
    }

    /**
     * Attempt an action over an indicated Appointment.
     *
     * @param User        $user
     * @param Appointment $appointment
     * @param string      $action
     *
     * @throws Exception
     *
     * @return App\Models\Appointment
     */
    public function requestAction(User $user, Appointment $appointment, $action)
    {
        switch ($action) {
            case 'annulate':
                $appointment->doAnnulate();
                break;
            case 'confirm':
                $appointment->doConfirm();
                event(new AppointmentWasConfirmed($user, $appointment));
                break;
            case 'serve':
                $appointment->doServe();
                break;
            default:
                // Ignore Invalid Action
                logger()->warning('Invalid Action request');

                throw new \Exception('Invalid Action Request');
                break;
        }

        // REFACTOR: $this->notify(notificationCategory, user, business, extraArgs)
        $date = $appointment->date;
        $code = $appointment->code;
        Notifynder::category('appointment.'.$action)
                   ->from('App\Models\User', $user->id)
                   ->to('App\Models\Business', $appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('code', 'action', 'date'))
                   ->send();

        return $appointment->fresh();
    }
}
