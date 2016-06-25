<?php

use App\Models\User;

trait CreateUser
{
    private function createUser($overrides = [])
    {
        return factory(User::class)->create($overrides);
    }

    private function makeUser()
    {
        $user = factory(User::class)->make();

        return $user;
    }
}
