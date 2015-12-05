<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param $userData
     * @return static
     */
    public function findOrCreate($userData)
    {
        $user = User::where('email', '=', $userData->email)->first();
        if ($user !== null) {
            return $user;
        }

        return User::create([
            'username' => $userData->nickname,
            'name' => $userData->nickname,
            'email' => $userData->email,
        ]);
    }
}
