<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

abstract class Model extends Eloquent
{
    use Rememberable;
}
