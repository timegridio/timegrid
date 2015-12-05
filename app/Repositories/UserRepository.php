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
        $user = User::where('email', '=', $userData->email)->orWhere('username', '=', $userData->nickname)->first();
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
