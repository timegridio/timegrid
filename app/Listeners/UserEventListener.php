<?php

namespace App\Listeners;

use Carbon\Carbon;

class UserEventListener
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($user)
    {
        $user->last_ip = request()->ip();
        $user->last_login_at = Carbon::now();
        $user->save();

        logger()->info("User logged in: UserId:{$user->id}");
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($user)
    {
        logger()->info("User logged out: UserId:{$user->id}");
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'auth.login',
            'App\Listeners\UserEventListener@onUserLogin'
        );

        $events->listen(
            'auth.logout',
            'App\Listeners\UserEventListener@onUserLogout'
        );
    }
}
