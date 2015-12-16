<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value');
            $table->enum('type', ['string', 'bool', 'int', 'float', 'array', 'time', 'json'])->default('string');
            $table->string('preferenceable_type');
            $table->integer('preferenceable_id')->unsigned();
            $table->timestamps();

            $table->unique(['key', 'preferenceable_type', 'preferenceable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('preferences');
    }
}
