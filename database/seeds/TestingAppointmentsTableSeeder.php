<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class TestingAppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('appointments')->delete();
        $business = \App\Business::where(['slug' => 'sample-biz'])->first();
        $contact = \App\Contact::where(['nin' => 'YA4128062'])->first();
        \App\Appointment::create(['contact_id' => $contact->id, 'business_id' => $business->id, 'start_at' => '2015-07-01 18:30:00', 'duration' => 30, 'comments' => 'Appointment example']);
    }
}
