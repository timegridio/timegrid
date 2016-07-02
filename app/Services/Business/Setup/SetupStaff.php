<?php

namespace App\Services\Business\Setup;

use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Humanresource;

class SetupStaff
{
    public static function createStaffMember(Business $business)
    {
        $name = $business->owner()->name;
        $capacity = 1;

        $humanresource = new Humanresource(compact('name', 'capacity'));

        $business->humanresources()->save($humanresource);
    }
}
