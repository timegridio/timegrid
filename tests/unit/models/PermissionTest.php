<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;
    use CreatePermission;

    /** @test */
    public function a_permission_belongs_to_many_roles()
    {
        $permission = $this->createPermission();

        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $permission->roles());
    }
}
