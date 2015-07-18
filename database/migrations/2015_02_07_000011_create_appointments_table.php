<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('issuer_id')->unsigned()->nullable();
			$table->foreign('issuer_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('contact_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
			$table->integer('business_id')->unsigned();
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->string('hash', 32)->unique();
			$table->enum('status', ['R','C', 'A', 'S']); // Reserved, Confirmed, Annulated, Served
			$table->timestamp('start_at')->index();
			$table->integer('duration')->nullable();
			$table->integer('service_id')->unsigned()->nullable();
			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
			$table->string('comments')->nullable();
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
		Schema::drop('appointments');
	}

}
