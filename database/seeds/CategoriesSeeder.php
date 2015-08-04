<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::updateOrCreate(['slug' => 'garage'], ['strategy' => 'dateslot', 'name' => 'Garage',  'description' => 'Vehicle repair and services']);
        Category::updateOrCreate(['slug' => 'doctor'], ['strategy' => 'dateslot', 'name' => 'Doctor',  'description' => 'Clinical Doctor']);
    }
}
