<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['slug', 'name', 'description', 'strategy'];

    public function businesses()
    {
        return $this->hasMany('App\Business')->withTimestamps();
    }

}
