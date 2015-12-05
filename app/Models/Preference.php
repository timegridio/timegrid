<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Preference extends EloquentModel
{
    /**
     * [$fillable description]
     *
     * @var [type]
     */
    protected $fillable = ['key', 'value', 'type'];

    /**
     * [preferenceable description]
     *
     * @return [type] [description]
     */
    public function preferenceable()
    {
        return $this->morphTo();
    }

    /**
     * [__toString description]
     *
     * @return string [description]
     */
    public function __toString()
    {
        return $this->attributes['value'];
    }

    /**
     * [getDefault description]
     *
     * @param  [type] $model [description]
     * @param  [type] $key   [description]
     * @return [type]        [description]
     */
    public static function getDefault($model, $key)
    {
        $class = get_class($model);
        $value = Config::get("preferences.{$class}.{$key}.value");
        $type = Config::get("preferences.{$class}.{$key}.type");
        return new Preference([
            'key' => $key,
            'value' => $value,
            'type' => $type,
            'preferenceable_type' => $class,
            'preferenceable_id' => $model
            ]);
    }

    /**
     * [question description]
     *
     * @return [type] [description]
     */
    public function question()
    {
        return trans("preferences.{$this->preferenceable_type}.question.{$this->key}");
    }

    /**
     * [help description]
     *
     * @return [type] [description]
     */
    public function help()
    {
        return trans("preferences.{$this->preferenceable_type}.help.{$this->key}");
    }

    /**
     * [scopeForKey description]
     *
     * @param  [type] $query [description]
     * @param  [type] $key   [description]
     * @return [type]        [description]
     */
    public function scopeForKey($query, $key)
    {
        return $query->where('key', $key);
    }

    /**
     * [value description]
     *
     * @return [type] [description]
     */
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
