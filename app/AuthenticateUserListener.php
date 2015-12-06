<?php

namespace App;

interface AuthenticateUserListener
{
    /**
     * @param $user
     *
     * @return mixed
     */
    public function userHasLoggedIn($user);
}
