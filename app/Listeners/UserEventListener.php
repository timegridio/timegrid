<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class UserEventListener
{
    /**
     * Handle user login events.
     */
    public function onUserLogin(Login $login)
    {
        $login->user->last_ip = request()->ip();
        $login->user->last_login_at = Carbon::now();
        $login->user->save();

        logger()->info("User logged in: UserId:{$login->user->id}");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout(Logout $logout)
    {
        logger()->info("User logged out");
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventListener@onUserLogout'
        );
    }
}
