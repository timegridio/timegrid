<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Service extends EloquentModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'business_id', 'description', 'prerequisites', 'duration', 'type_id', 'color'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'slug'];

    /**
     * Belongs to service type.
     *
     * @return Illuminate\Database\Query Relationship Service belongs to type query
     */
    public function type()
    {
        return $this->belongsTo('Timegridio\Concierge\Models\ServiceType');
    }

    /**
     * Get service type name.
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        if ($this->type()) {
            return $this->type->name;
        }

        return;
    }

    /**
     * belongs to Business.
     *
     * @return Illuminate\Database\Query Relationship Service belongs to Business query
     */
    public function business()
    {
        return $this->belongsTo('Timegridio\Concierge\Models\Business');
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

    //////////////
    // Mutators //
    //////////////

    /**
     * set Duration Attribute.
     * 
     * @param int $duration
     */
    public function setDurationAttribute($duration)
    {
        return $this->attributes['duration'] = $duration ? intval($duration) : null;
    }

    ////////////
    // Scopes //
    ////////////

    /**
     * Scope Slug.
     *
     * @param Illuminate\Database\Query $query
     * @param string                    $slug  Slug of the desired Service
     *
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', '=', $slug)->get();
    }
}
