<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ContactsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('contacts')->delete();

        \App\Contact::create(['firstname' => 'Ariel', 'lastname' => 'Vallese', 'nin' => 'YA4128062', 'birthdate' => '1985-01-16', 'mobile' => '0034651464218', 'notes' => 'alariva', 'gender' => 'M']);
        \App\Contact::create(['firstname' => 'Mauricio', 'lastname' => 'Vallese', 'nin' => '10123456', 'birthdate' => '1955-01-30', 'mobile' => '0054953250127', 'notes' => 'mvallese', 'gender' => 'M']);
    }
}
