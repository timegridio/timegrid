<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class TestingBusinessesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('businesses')->delete();
        $business = \App\Business::create(['name' => 'Sample Biz', 'slug' => 'sample-biz', 'description' => 'Sample business', 'timezone' => 'America/Argentina/Buenos_Aires']);

        $user = \App\User::where(['email' => 'alariva@gmail.com'])->first();
        $user->businesses()->attach($business);
        $user->save();
    }
}
