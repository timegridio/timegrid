<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;

class VacanciesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('vacancies')->delete();
        $business = \App\Business::where(['slug' => 'sample-biz'])->first();
        $service = \App\Service::where(['slug' => 'masaje'])->first();

        \App\Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today +7 days')), $business->timezone)->timezone('UTC')->toDateString(), 'start_at' => Carbon::parse(date('Y-m-d H:i:s', strtotime('today +7 days')), $business->timezone)->timezone('UTC')->toDateTimeString(), 'business_id' => $business->id, 'service_id' => $service->id]);
        \App\Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today +8 days')), $business->timezone)->timezone('UTC')->toDateString(), 'start_at' => Carbon::parse(date('Y-m-d H:i:s', strtotime('today +8 days')), $business->timezone)->timezone('UTC')->toDateTimeString(), 'business_id' => $business->id, 'service_id' => $service->id]);
    }
}
