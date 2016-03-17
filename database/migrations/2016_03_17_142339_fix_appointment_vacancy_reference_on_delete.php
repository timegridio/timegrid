<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAppointmentVacancyReferenceOnDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function ($table) {
            $table->dropForeign(['vacancy_id']);
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('set null');
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
            $table->dropForeign(['vacancy_id']);
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('set null');
        });
    }
}
