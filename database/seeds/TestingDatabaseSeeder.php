<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        #$this->call('CountriesSeeder');
        #$this->command->info('Seeded the Param Countries!');

        $this->call('TestingUsersTableSeeder');
        $this->command->info('Seeded the Sample Users!');
    
        $this->call('TestingBusinessesTableSeeder');
        $this->command->info('Seeded the Sample Businesses!');

        #$this->call('TestingServicesTableSeeder');
        #$this->command->info('Seeded the Sample Businesses Services!');

        #$this->call('TestingContactsTableSeeder');
        #$this->command->info('Seeded the Sample Contacts!');

        #$this->call('TestingAppointmentsTableSeeder');
        #$this->command->info('Seeded the Sample Appointments!');

        #$this->call('TestingVacanciesTableSeeder');
        #$this->command->info('Seeded the Sample Vacancies!');
    }
}
