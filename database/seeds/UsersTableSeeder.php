<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
    	DB::table('users')->delete();
        // TestDummy::times(20)->create('App\Post');
        \App\User::create(['email' => 'alariva@gmail.com', 'password' => bcrypt('123123')]);
    }
}
