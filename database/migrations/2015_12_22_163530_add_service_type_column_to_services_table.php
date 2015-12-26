<?php

use Illuminate\Database\Migrations\Migration;

class AddServiceTypeColumnToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function ($table) {
            $table->integer('type_id')->unsigned()->nullable()->after('id');
            $table->foreign('type_id')->references('id')->on('service_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function ($table) {
            $table->dropForeign('services_type_id_foreign');
            $table->dropColumn('type_id');
        });
    }
}
