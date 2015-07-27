<?php

namespace App;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'business_id', 'description', 'prerequisites', 'duration'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'slug'];

    /**
     * belongs to Business
     * @return Illuminate\Database\Query Relationship Service belongs to Business query
     */
    public function business()
    {
        return $this->belongsTo('App\Business');
    }

    /**
     * TODO: Check slug setting can be moved to a more proper place
     * 
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = array())
    {
        $this->attributes['slug'] = str_slug($this->attributes['name']);

        return parent::save();
    }

    ////////////
    // Scopes //
    ////////////

    /**
     * Scope Slug
     * @param  Illuminate\Database\Query $query
     * @param  string $slug  Slug of the desired Service
     * @return Illuminate\Database\Query Scoped query
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', '=', $slug)->get();
    }
}
