<?php

namespace App\Http\ViewComposers;

use Creativeorange\Gravatar\Facades\Gravatar;

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

        if (auth()->user()) {
            view()->share('gravatarURL', Gravatar::get(auth()->user()->email, ['size' => 24, 'secure' => true]));
            view()->share('appointments', auth()->user()->appointments()->active()->get());
        } else {
            view()->share('gravatarURL', 'http://placehold.it/150x150');
            view()->share('appointments', []);
        }
    }
}
