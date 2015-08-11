<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;
use App\Category;   

class TestingBusinessesTableSeeder extends Seeder
{
    public function run()
    {
        $category = Category::where('slug', 'garage')->first();

        $business = \App\Business::create(['name' => 'HGNC', 'slug' => 'hgnc', 'description' => 'Taller de Hernán GNC', 'timezone' => 'America/Argentina/Buenos_Aires', 'category_id' => $category->id]);

        $user = \App\User::where(['email' => 'alariva@gmail.com'])->first();
        $user->businesses()->attach($business);
        $user->save();
    }
}
