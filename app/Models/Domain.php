<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domain extends EloquentModel
{
    use SoftDeletes;

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = ['slug', 'owner_id'];

    /**
     * Guarded attributes.
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Has many businesses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businesses()
    {
        return $this->owner->businesses();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
