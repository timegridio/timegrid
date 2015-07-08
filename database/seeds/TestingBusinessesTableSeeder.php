<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class TestingBusinessesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('businesses')->delete();
        $business = \App\Business::create(['name' => 'HGNC', 'slug' => 'hgnc', 'description' => 'Taller de Hernán GNC', 'timezone' => 'America/Argentina/Buenos_Aires']);

        $user = \App\User::where(['email' => 'alariva@gmail.com'])->first();
        $user->businesses()->attach($business);
        $user->save();
    }
}
