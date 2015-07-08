<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['slug', 'name', 'description', 'timezone', 'strategy'];

    public function owners()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps();
    }

    public function owner()
    {
        return $this->belongsToMany(config('auth.model'))->withTimestamps()->first();
    }

    public function contacts()
    {
        return $this->belongsToMany('App\Contact');
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function vacancies()
    {
        return $this->hasMany('App\Vacancy');
    }

    public function availability($days = 10)
    {
        $dates = [];
        for ($i=0; $i < $days; $i++) {
            $dates[date('Y-m-d', strtotime("today +$i days"))] = [];
        }
        $vacancies = $this->vacancies;
        foreach ($vacancies as $key => $vacancy) {
            if (array_key_exists($vacancy->date, $dates)) {
                $dates[$vacancy->date][] = $vacancy;
            }
        }
        return $dates;
    }
}
