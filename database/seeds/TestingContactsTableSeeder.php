<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class TestingContactsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('contacts')->delete();

        $business = \App\Business::where(['slug' => 'hgnc'])->first();

        $contact = \App\Contact::create(['firstname' => 'Ariel', 'lastname' => 'Vallese', 'nin' => 'YA4128062', 'birthdate' => '1985-01-16', 'mobile' => '651464218', 'mobile_country' => 'ES', 'notes' => 'alariva', 'gender' => 'M']);
        $contact->businesses()->attach($business);

        $contact = \App\Contact::create(['firstname' => 'Mauricio', 'lastname' => 'Vallese', 'nin' => '10123456', 'birthdate' => '1955-01-30', 'mobile' => '91153250127', 'mobile_country' => 'AR', 'notes' => 'mvallese', 'gender' => 'M']);
        $contact->businesses()->attach($business);
    }
}
