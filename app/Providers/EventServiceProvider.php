<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewRegisteredUser' => [
            'App\Handlers\Events\LinkUserToExistingContacts',
            'App\Handlers\Events\SendMailUserWelcome',
        ],
        'App\Events\NewBooking' => [
            'App\Handlers\Events\SendBookingNotification',
        ],
        'App\Events\NewRegisteredContact' => [
            'App\Handlers\Events\LinkContactToExistingUser',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}
