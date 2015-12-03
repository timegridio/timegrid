<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    protected $baseUrl = 'http://localhost:8000';
 
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function prepareForTests()
    {
        Mail::pretend(true);
    }

    public function setupDatabase()
    {
        # Artisan::call('migrate:reset');
        # Artisan::call('db:seed', array('--class'=>'TestingDatabaseSeeder'));
    }

    public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();
    }

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }
}
