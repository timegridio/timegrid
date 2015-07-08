<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class TestingServicesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('services')->delete();
        $business = \App\Business::where(['slug' => 'sample-biz'])->first();
        \App\Service::create(['name' => 'Masaje', 'business_id' => $business->id, 'description' => 'Masajes', 'duration' => 30 ]);
        \App\Service::create(['name' => 'Crema', 'business_id' => $business->id, 'description' => 'Cremas', 'duration' => 20 ]);
    }
}
