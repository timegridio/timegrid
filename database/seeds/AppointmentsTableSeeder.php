<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        \App\Appointment::create(['contact_id' => 26, 'business_id' => 57, 'date' => '2015-07-01', 'time' => '18:30:00', 'duration' => 30, 'comments' => 'Appointment example']);
    }
}
