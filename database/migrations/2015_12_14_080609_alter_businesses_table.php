<?php

use Illuminate\Database\Migrations\Migration;

class AlterBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function ($table) {
            $table->string('country_code', 2)->nullable()->index();
            $table->string('locale', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function ($table) {
            $table->dropColumn('country_code');
            $table->dropColumn('locale');
        });
    }
}
