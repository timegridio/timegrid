<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @property Illuminate\Support\Collection $roles
 */
class Permission extends EloquentModel
{
    /**
     * A permission can be applied to roles.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
