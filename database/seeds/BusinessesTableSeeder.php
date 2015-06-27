<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class BusinessesTableSeeder extends Seeder
{
    public function run()
    {
    	DB::table('businesses')->delete();
        // TestDummy::times(20)->create('App\Post');
        $business = \App\Business::create(['name' => 'Sample Biz', 'slug' => 'sample-biz', 'description' => 'Sample business']);

		$user = \App\User::where(['email' => 'alariva@gmail.com'])->first();

		$user->businesses()->attach($business);

		$user->save();
    }
}
