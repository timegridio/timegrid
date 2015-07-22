<?php

namespace App\Traits;

trait Preferenceable
{
    public function preferences()
    {
        return $this->morphMany('App\Preference', 'preferenceable');
    }

    public function pref($key, $value = null, $type = 'string')
    {
        if ($value) {
            $this->preferences()->updateOrCreate(['key' => $key], ['value' => $value, 'type' => $type]);
        }
        $default = \App\Preference::getDefault($this, $key);
        return($pref = $this->preferences()->forKey($key)->first()) ? $pref->value() : $default->value();
    }
}