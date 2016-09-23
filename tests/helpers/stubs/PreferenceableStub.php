<?php

namespace App\Tests\Helpers\Stubs;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Preferenceable;

class PreferenceableStub extends Model
{
    use Preferenceable;

    protected $fillable = ['id'];
}
