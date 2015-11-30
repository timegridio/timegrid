<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('NotifynderCategoriesSeeder');
        $this->command->info('Seeded the Notifynder Categories!');

        $this->call('CategoriesSeeder');
        $this->command->info('Seeded the Param Categories!');

        $this->call('CountriesSeeder');
        $this->command->info('Seeded the Param Countries!');

        $this->call('RolesTableSeeder');
        $this->command->info('Seeded the Param Roles!');
    }
}
