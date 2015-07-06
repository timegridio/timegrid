<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'business_id', 'description', 'duration'];

    protected $guarded = ['id', 'slug'];

    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    public function save(array $options = array())
    {
        $this->attributes['slug'] = str_slug($this->attributes['name']);

        parent::save();
    }
}
