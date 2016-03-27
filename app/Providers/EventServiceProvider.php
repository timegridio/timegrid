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
            'App\Handlers\Events\SendMailUserWelcome',
        ],
        'App\Events\NewAppointmentWasBooked' => [
            'App\Handlers\Events\SendBookingNotification',
        ],
        'App\Events\NewContactWasRegistered' => [
            'App\Handlers\Events\LinkContactToExistingUser',
        ],
        'App\Events\AppointmentWasConfirmed' => [
            'App\Handlers\Events\SendAppointmentConfirmationNotification',
        ],
        'App\Events\AppointmentWasCanceled' => [
            'App\Handlers\Events\SendAppointmentCancellationNotification',
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
