<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::updateOrCreate(['slug' => 'root'],         ['name' => 'Root',         'description' => 'System administration only']);
        // Role::updateOrCreate(['slug' => 'manager'],      ['name' => 'Manager',      'description' => 'Business manager']);
        // Role::updateOrCreate(['slug' => 'collaborator'], ['name' => 'Collaborator', 'description' => 'Business manager with restricted access']);
        // Role::updateOrCreate(['slug' => 'user'],         ['name' => 'User',         'description' => 'Business customer/user']);
    }
}
