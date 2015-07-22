<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public function preferenceable()
    {
      return $this->morphTo();
    }

    public function __toString()
    {
        return $this->attributes['value'];
    }

    public static function getDefault($model, $key)
    {
        $class = get_class($model);
        $value = \Config::get("preferences.{$class}.{$key}.value");
        $type = \Config::get("preferences.{$class}.{$key}.type");
        return new Preference(['key' => $key, 'value' => $value, 'type' => $type, 'preferenceable_type' => $class, 'preferenceable_id' => $model]);
    }

    public function question()
    {
        return trans("preferences.{$this->preferenceable_type}.question.{$this->key}");
    }

    public function help()
    {
        return trans("preferences.{$this->preferenceable_type}.help.{$this->key}");
    }

    public function scopeForKey($query, $key)
    {
        return $query->where('key', $key);
    }

    public function value()
    {
        switch ($this->type) {
            case 'string':
                return (string) $this->value;
                break;
            case 'bool':
                return (bool) $this->value;
                break;
            case 'int':
                return (int) $this->value;
                break;
            case 'float':
                return (float) $this->value;
                break;
            case 'json':
                return json_decode($this->value);
                break;
            case 'array':
                return unserialize($this->value);
                break;
            default:
                break;
        }
        return $this->value;
    }
}