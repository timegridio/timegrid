<?php

namespace App;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'name', 'description', 'strategy'];

    /**
     * clasifies Businesses
     * 
     * @return Illuminate\Database\Query Relationship Category has Businesses query
     */
    public function businesses()
    {
        return $this->hasMany('App\Business')->withTimestamps();
    }
}
