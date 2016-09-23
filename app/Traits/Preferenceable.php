<?php

namespace App\Traits;

use App\Models\Preference;

trait Preferenceable
{
    public function preferences()
    {
        return $this->morphMany('App\Models\Preference', 'preferenceable');
    }

    public function pref($key, $value = null, $type = 'string')
    {
        if (isset($value)) {
            $value = $this->cast($value, $type);

            $this->preferences()->updateOrCreate(compact('key'), compact('value', 'type'));

            return $value;
        }

        $pref = $this->preferences()->forKey($key)->first();

        if ($pref !== null) {
            return $pref->value();
        }

        $default = Preference::getDefault($this, $key);

        return  $default->value();
    }

    private function cast($value, $type)
    {
        switch ($type) {
            case 'bool':
                $value = boolval($value);
                break;
            case 'int':
                $value = intval($value);
                break;
            case 'float':
                $value = floatval($value);
                break;
            case 'string':
                $value = (string) $value;
                break;
            default:
                // No changes
                break;
        }

        return $value;
    }
}
