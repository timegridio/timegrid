<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @property string $key
 * @property mixed $value
 * @property string $type
 */
class Preference extends EloquentModel
{

    protected $fillable = ['key', 'value', 'type'];

    public function preferenceable()
    {
        return $this->morphTo();
    }

    /**
     * [__toString description].
     *
     * @return string $value
     */
    public function __toString()
    {
        return $this->attributes['value'];
    }

    /**
     * Get default value.
     *
     * @param string $model
     * @param string $key
     *
     * @return mixed
     */
    public static function getDefault($model, $key)
    {
        $class = get_class($model);
        $value = config("preferences.{$class}.{$key}.value");
        $type = config("preferences.{$class}.{$key}.type");

        return new self([
            'key'                 => $key,
            'value'               => $value,
            'type'                => $type,
            'preferenceable_type' => $class,
            'preferenceable_id'   => $model,
            ]);
    }

    /**
     * [question description].
     *
     * @return string
     */
    public function question()
    {
        return trans("preferences.{$this->preferenceable_type}.question.{$this->key}");
    }

    /**
     * [help description].
     *
     * @return string
     */
    public function help()
    {
        return trans("preferences.{$this->preferenceable_type}.help.{$this->key}");
    }

    /**
     * [scopeForKey description].
     *
     * @param [type] $query [description]
     * @param [type] $key   [description]
     *
     * @return [type] [description]
     */
    public function scopeForKey($query, $key)
    {
        return $query->where('key', $key);
    }

    /**
     * Get casted value.
     *
     * @return mixed
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
            default:
                break;
        }

        return $this->value;
    }
}
