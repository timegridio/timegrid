<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDomainIdToBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function ($table) {
            $table->integer('domain_id')->unsigned()->nullable()->after('category_id');
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('set null');
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
            $table->dropForeign('businesses_domain_id_foreign');
            $table->dropColumn('domain_id');
        });
    }
}
