<?php

use Illuminate\Database\Migrations\Migration;

class AddHumanresourcesForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function ($table) {
            $table->integer('humanresource_id')->unsigned()->nullable();
            $table->foreign('humanresource_id')->references('id')->on('humanresources')->onDelete('cascade');
        });

        Schema::table('vacancies', function ($table) {
            $table->integer('humanresource_id')->unsigned()->nullable();
            $table->foreign('humanresource_id')->references('id')->on('humanresources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function ($table) {
            $table->dropForeign(['humanresource_id']);
            $table->dropColumn('humanresource_id');
        });

        Schema::table('vacancies', function ($table) {
            $table->dropForeign(['humanresource_id']);
            $table->dropColumn('humanresource_id');
        });
    }
}
