<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('CountriesSeeder');
		$this->command->info('Seeded the Param Countries!'); 

		$this->call('BusinessesTableSeeder');
		$this->command->info('Seeded the Sample Businesses!'); 

		$this->call('ContactsTableSeeder');
		$this->command->info('Seeded the Sample Contacts!'); 

		$this->call('AppointmentsTableSeeder');
		$this->command->info('Seeded the Sample Appointments!'); 


	}

}
