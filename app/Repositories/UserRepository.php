<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * @param $userData
     * @return static
     */
    public function findOrCreate($userData)
    {
        $user = User::where('email', '=', $userData->email);
        if ($user !== null) {
            return $user;
        }

        return User::create([
            'name'     => $userData->nickname,
            'email'    => $userData->email,
        ]);
    }
}
