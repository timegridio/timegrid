<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\AuthenticateUser;
use App\AuthenticateUserListener;
//Add These three required namespace
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;

class OAuthController extends Controller implements AuthenticateUserListener
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        $this->redirectPath = route('home');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function handleProviderCallback($provider, AuthenticateUser $authenticateUser, Request $request)
    {
        $hasCode = $request->has('code');
        return $authenticateUser->execute($provider, $hasCode, $this);
    }

    public function userHasLoggedIn($user)
    {
        return redirect('/');
    }
}
