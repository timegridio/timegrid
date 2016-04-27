<?php

use App\Models\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateRole, CreatePermission;

    /** @test */
    public function a_role_may_belong_to_a_user()
    {
        $user = $this->createUser();

        $role = $this->createRole();

        $user->roles()->save($role);

        $this->assertTrue($user->hasRole($role->name));
        $this->assertTrue($user->hasRole($user->roles));
    }

    /** @test */
    public function a_role_establishes_permissions()
    {
        $role = $this->createRole();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $role->permissions());
    }

    /** @test */
    public function a_role_gives_permissions()
    {
        $permission = $this->createPermission();

        $role = $this->createRole();

        $role->givePermissionTo($permission);

        $this->assertInstanceOf(Permission::class, $role->permissions()->first());
    }
}
