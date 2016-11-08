<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PatchUpdatePreferencesKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('preferences')
                    ->where('key', 'appointment_annulation_pre_hs')
                    ->update(['key' => 'appointment_cancellation_pre_hs']);

        DB::table('preferences')
                    ->where('key', 'annulation_policy_advice')
                    ->update(['key' => 'cancellation_policy_advice']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('preferences')
                    ->where('key', 'appointment_cancellation_pre_hs')
                    ->update(['key' => 'appointment_annulation_pre_hs']);

        DB::table('preferences')
                    ->where('key', 'cancellation_policy_advice')
                    ->update(['key' => 'annulation_policy_advice']);
    }
}
