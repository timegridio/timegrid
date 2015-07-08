<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;
use App\Business;
use App\Service;

class TestingServicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->delete();
        $business = Business::where(['slug' => 'hgnc'])->first();

        Service::create(['business_id'=> $business->id, 'name' => 'Instalación', 'description' => 'Instalación de equipo GNC']);
        Service::create(['business_id'=> $business->id, 'name' => 'Regulación', 'description' => 'Regulación']);
        Service::create(['business_id'=> $business->id, 'name' => 'Mecánica General', 'description' => 'Mecánica General']);
    }
}
