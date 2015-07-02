<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        \App\User::create(['email' => 'alariva@gmail.com', 'password' => bcrypt('123123')]);
    }
}
