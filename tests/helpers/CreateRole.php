<?php

use App\Models\Role;

trait CreateRole
{
    private function createRole($overrides = [])
    {
        return factory(Role::class)->create($overrides);
    }

    private function makeRole()
    {
        $role = factory(Role::class)->make();

        return $role;
    }
}
