<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserWasRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
                'email'                => 'required|email|max:255|unique:users',
                'password'             => 'required|confirmed|min:6',
                'g-recaptcha-response' => 'required|captcha',
                'allow_register_user'  => 'required|accepted',
            ];

        if (app()->environment('local') || app()->environment('testing')) {
            unset($rules['g-recaptcha-response']);
        }

        $data['allow_register_user'] = config('root.app.allow_register_user', true);

        $messages = [
            'allow_register_user.accepted' => trans('app.allow_register_user'),
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => md5("{$data['name']}/{$data['email']}"),
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        event(new NewUserWasRegistered($user));

        return $user;
    }
}
