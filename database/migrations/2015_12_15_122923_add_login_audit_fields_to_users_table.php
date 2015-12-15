<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

define('IPV4_STR_MAX_LENGTH', 15);
define('IPV6_STR_MAX_LENGTH', 45);

class AddLoginAuditFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_ip', IPV6_STR_MAX_LENGTH)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('last_login_at');
            $table->dropColumn('last_ip');
        });
    }
}
