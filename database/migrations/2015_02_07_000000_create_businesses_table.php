<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description');
            $table->string('postal_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('timezone');
            $table->enum('strategy', ['dateslot', 'timeslot'])->default('timeslot'); /* Appointment Booking Strategy */
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businesses');
    }

}
