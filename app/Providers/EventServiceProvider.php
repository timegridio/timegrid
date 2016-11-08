<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\NewUserWasRegistered::class => [
            \App\Listeners\AutoConfigureUserPreferences::class,
            \App\Listeners\SendMailUserWelcome::class,
        ],
        \App\Events\NewAppointmentWasBooked::class => [
            \App\Listeners\SendBookingNotification::class,
        ],
        \App\Events\NewContactWasRegistered::class => [
            \App\Listeners\LinkContactToExistingUser::class,
        ],
        \App\Events\AppointmentWasConfirmed::class => [
            \App\Listeners\SendAppointmentConfirmationNotification::class,
        ],
        \App\Events\AppointmentWasCanceled::class => [
            \App\Listeners\SendAppointmentCancellationNotification::class,
        ],
        \App\Events\NewSoftAppointmentWasBooked::class => [
            \App\Listeners\SendSofAppointmentValidationRequest::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        \App\Listeners\UserEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
