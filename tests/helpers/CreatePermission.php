<?php

use App\Models\Permission;

trait CreatePermission
{
    private function createPermission($overrides = [])
    {
        return factory(Permission::class)->create($overrides);
    }

    private function makePermission()
    {
        $permission = factory(Permission::class)->make();

        return $permission;
    }
}
