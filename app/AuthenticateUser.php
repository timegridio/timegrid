<?php

namespace App;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AuthenticateUser
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param UserRepository $users
     * @param Socialite $socialite
     * @param Guard $auth
     */
    public function __construct(UserRepository $users, Socialite $socialite, Guard $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
    }

    /**
     * @param boolean $hasCode
     * @param AuthenticateUserListener $listener
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($provider, $hasCode, AuthenticateUserListener $listener)
    {
        if (! $hasCode) {
            return $this->getAuthorizationFirst($provider);
        }

        $providerUser = $this->getUser($provider);

        logger()->info('PROVIDER USER:'.serialize($providerUser));

        $user = $this->users->findOrCreate($providerUser);
        if ($user === null) {
            return $this->getAuthorizationFirst($provider);
        }
        $this->auth->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst($provider)
    {
        return $this->socialite->driver($provider)->redirect();
    }

    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getUser($provider)
    {
        return $this->socialite->driver($provider)->user();
    }
}
