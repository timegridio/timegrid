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
        if (isset($value)) {
            $this->preferences()->updateOrCreate(['key' => $key], ['value' => $this->cast($value, $type), 'type' => $type]);
            return $value;
        }
        $default = \App\Preference::getDefault($this, $key);
        return($pref = $this->preferences()->forKey($key)->first()) ? $pref->value() : $default->value();
    }

    private function cast($value, $type)
    {
        switch ($type) {
            case 'bool':
                return boolval($value);
                break;
            case 'int':
                return intval($value);
                break;
            case 'float':
                return floatval($value);
                break;
            case 'string':
                return $value;
                break;
            default:
                return $value;
                break;
        }
    }
}