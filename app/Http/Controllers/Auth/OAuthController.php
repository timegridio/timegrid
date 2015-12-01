<?php

namespace App\Http\Controllers\Auth;

use App\AuthenticateUser;
use Illuminate\Http\Request;
use App\AuthenticateUserListener;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class OAuthController extends Controller implements AuthenticateUserListener
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        $this->redirectPath = route('home');
    }

    /**
     * [redirectToProvider description]
     *
     * @param  [type] $provider [description]
     * @return [type]           [description]
     */
    public function redirectToProvider($provider)
    {
        $this->log->info(__METHOD__);
        $this->log->info(sprintf("  provider:%s", $provider));

        return Socialite::driver($provider)->redirect();
    }

    /**
     * [handleProviderCallback description]
     *
     * @param  [type]           $provider         [description]
     * @param  AuthenticateUser $authenticateUser [description]
     * @param  Request          $request          [description]
     * @return [type]                             [description]
     */
    public function handleProviderCallback($provider, AuthenticateUser $authenticateUser, Request $request)
    {
        $hasCode = $request->has('code');
        return $authenticateUser->execute($provider, $hasCode, $this);
    }

    /**
     * [userHasLoggedIn description]
     *
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function userHasLoggedIn($user)
    {
        return redirect()->intended($this->redirectPath());
    }
}
