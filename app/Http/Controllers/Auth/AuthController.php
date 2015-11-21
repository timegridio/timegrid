<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Validation\ValidationServiceProvider;
use App\Http\Controllers\Controller;
use App\Events\NewRegisteredUser;
use App\User;
use Validator;
use Event;
use Log;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        if (env('APP_ENV') != 'local') {
            return Validator::make($data, [
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'g-recaptcha-response' => 'required|captcha'
            ]);
        } else {
            return Validator::make($data, [
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6'
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        Log::info("AuthController: create: email:<{$data['email']}> name:<{$data['name']}>");
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        Event::fire(new NewRegisteredUser($user));
        return $user;
    }
}
