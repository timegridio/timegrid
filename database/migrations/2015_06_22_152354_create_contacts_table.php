<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('nin')->nullable()->index();
			$table->enum('gender', ['M','F']);
			$table->string('firstname');
			$table->string('lastname');
			$table->string('occupation')->nullable();
			$table->string('martial_status')->nullable();
			$table->string('postal_address')->nullable();
			$table->date('birthdate')->nullable();
			$table->char('mobile', 15)->nullable();
			$table->char('mobile_country', 2)->nullable();
			$table->string('notes')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}
