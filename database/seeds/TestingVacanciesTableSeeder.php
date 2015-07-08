<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory as TestDummy;
use App\Business;
use App\Service;
use App\Vacancy;

class TestingVacanciesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('vacancies')->delete();
        $business = Business::where(['slug' => 'hgnc'])->first();
        $service_i = Service::where(['slug' => 'instalacion'])->first();
        $service_r = Service::where(['slug' => 'regulacion'])->first();
        $service_m = Service::where(['slug' => 'mecanica-general'])->first();

        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +7 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_i->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +8 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_i->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +9 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_i->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +6 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_m->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +7 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_m->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +8 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_m->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +8 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_r->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today  +9 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_r->id]);
        Vacancy::create(['date' => Carbon::parse(date('Y-m-d', strtotime('today +10 days')), $business->timezone)->timezone('UTC')->toDateString(), 'business_id' => $business->id, 'service_id' => $service_r->id]);
    }
}
