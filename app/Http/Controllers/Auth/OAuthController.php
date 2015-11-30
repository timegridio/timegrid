<?php

namespace App\Http\Controllers\Auth;

# use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\AuthenticateUser;
use App\AuthenticateUserListener;
//Add These three required namespace
use Laravel\Socialite\Facades\Socialite;
#use Illuminate\Support\Facades\Auth;
#use App\User;

class OAuthController extends Controller implements AuthenticateUserListener
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * [__construct description]
     */
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
