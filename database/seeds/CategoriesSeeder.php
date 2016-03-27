<?php

use Illuminate\Database\Seeder;
use Timegridio\Concierge\Models\Category;

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
        Category::updateOrCreate(['slug' => 'martial-arts'], ['strategy' => 'timeslot', 'name' => 'Martial Arts',  'description' => 'Martial Arts']);
        Category::updateOrCreate(['slug' => 'yoga'], ['strategy' => 'timeslot', 'name' => 'Yoga',  'description' => 'Yoga']);
        Category::updateOrCreate(['slug' => 'consulting'], ['strategy' => 'timeslot', 'name' => 'Consulting',  'description' => 'Consulting']);
        Category::updateOrCreate(['slug' => 'hairdresser'], ['strategy' => 'timeslot', 'name' => 'Hairdresser',  'description' => 'Hairdresser']);
        Category::updateOrCreate(['slug' => 'beauty'], ['strategy' => 'timeslot', 'name' => 'Beauty & Healthcare',  'description' => 'Beauty & Healthcare']);
    }
}
