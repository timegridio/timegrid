<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserWasRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Event;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Validator;

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
     * @param \Illuminate\Contracts\Auth\Guard     $auth
     * @param \Illuminate\Contracts\Auth\Registrar $registrar
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        parent::__construct();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $rules = [
                'username'             => 'required|min:3|max:25|unique:users',
                'email'                => 'required|email|max:255|unique:users',
                'password'             => 'required|confirmed|min:6',
                'g-recaptcha-response' => 'required|captcha',
            ];

        if (app()->environment('local') || app()->environment('testing')) {
            unset($rules['g-recaptcha-response']);
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        event(new NewUserWasRegistered($user));

        return $user;
    }
}
