<?php

namespace App\Http\ViewComposers;

use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Support\Facades\Cache;

class AuthComposer
{
    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose()
    {
        view()->share('isGuest', auth()->guest());
        view()->share('signedIn', auth()->check());
        view()->share('user', auth()->user());
        view()->share('timezone', session()->get('timezone'));

        if (auth()->user()) {
            view()->share('gravatarURL', Gravatar::get(auth()->user()->email, ['size' => 24, 'secure' => true]));
            view()->share('appointments', $this->getActiveAppointments());
        } else {
            view()->share('gravatarURL', 'http://placehold.it/150x150');
            view()->share('appointments', collect([]));
        }
    }

    protected function getActiveAppointments()
    {
        return Cache::get('user-{auth()->id()}-active-appointments', function () {
            return auth()->user()->appointments()->active()->get();
        });
    }
}
