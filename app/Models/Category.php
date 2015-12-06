<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Category extends EloquentModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name', 'description', 'strategy'];

    /**
     * clasifies Businesses.
     *
     * @return Illuminate\Database\Query Relationship Category has Businesses query
     */
    public function businesses()
    {
        return $this->hasMany('App\Models\Business')->withTimestamps();
    }
}
