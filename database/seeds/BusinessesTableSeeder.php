<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class BusinessesTableSeeder extends Seeder
{
    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        $business = \App\Business::create(['name' => 'Sample Biz', 'slug' => 'sample-biz', 'description' => 'Sample business']);

		$user = \App\User::findOrFail(1);

		$user->attach($business);

		$user->save();
    }
}
