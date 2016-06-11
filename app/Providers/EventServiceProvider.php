<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewUserWasRegistered' => [
            'App\Listeners\AutoConfigureUserPreferences',
            'App\Listeners\SendMailUserWelcome',
        ],
        'App\Events\NewAppointmentWasBooked' => [
            'App\Listeners\SendBookingNotification',
        ],
        'App\Events\NewContactWasRegistered' => [
            'App\Listeners\LinkContactToExistingUser',
        ],
        'App\Events\AppointmentWasConfirmed' => [
            'App\Listeners\SendAppointmentConfirmationNotification',
        ],
        'App\Events\AppointmentWasCanceled' => [
            'App\Listeners\SendAppointmentCancellationNotification',
        ],
        'App\Events\NewSoftAppointmentWasBooked' => [
            'App\Listeners\SendSofAppointmentValidationRequest'
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UserEventListener',
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
