<?php

use Timegridio\Concierge\Models\Category;
use Illuminate\Database\Seeder;

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
        Category::updateOrCreate(['slug' => 'doctor'], ['strategy' => 'timeslot', 'name' => 'Doctor',  'description' => 'Clinical Doctor']);
        Category::updateOrCreate(['slug' => 'photography'], ['strategy' => 'timeslot', 'name' => 'Photographer',  'description' => 'Photographer']);
        Category::updateOrCreate(['slug' => 'spa'], ['strategy' => 'timeslot', 'name' => 'Spa',  'description' => 'Spa & Beauty']);
    }
}
