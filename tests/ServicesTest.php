<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Business;
use App\Service;

class ServicesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests that Bootstrapper is installed and working
     *
     * @return void
     */
    public function testServiceCreation()
    {
        $business = Business::find(1);
        $service = Service::create(['business_id'=> $business->id, 'name' => 'Instalación', 'description' => 'Instalación de equipo GNC']);
        $this->seeInDatabase('services', ['slug' => 'instalacion']);
        $service = Service::create(['business_id'=> $business->id, 'name' => 'Regulación', 'description' => 'Regulación']);
        $this->seeInDatabase('services', ['slug' => 'regulacion']);
        $service = Service::create(['business_id'=> $business->id, 'name' => 'Mecánica General', 'description' => 'Mecánica General']);
        $this->seeInDatabase('services', ['slug' => 'mecanica-general']);
    }
}
