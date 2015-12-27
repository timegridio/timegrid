<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'slug'];

    /**
     * Has many services.
     *
     * @return Illuminate\Database\Query Relationship
     */
    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    /**
     * TODO: Check slug setting can be moved to a more proper place.
     *
     * Save the model to the database.
     *
     * @param array $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->attributes['slug'] = str_slug($this->attributes['name']);

        return parent::save($options);
    }
}
