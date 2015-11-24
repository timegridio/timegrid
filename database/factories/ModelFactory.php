<?php // app/database/factories/ModelFactory.php

$factory->define('App\User', function () {
    $faker = Faker\Factory::create();
    return [
        'name' => 'Ariel',
        'email' => 'alariva@timegrid.io',
        'password' => bcrypt('stubpassword')
    ];
});

$factory->define('App\Contact', function () {
    $faker = Faker\Factory::create();
    return [
        'firstname' => 'Ariel',
        'lastname' => 'Vallese',
        'nin' => '12345678',
        'email' => 'alariva@timegrid.io',
        'birthdate' => null,
        'mobile' => null,
        'mobile_country' => null,
        'gender' => 'M',
        'occupation' => null,
        'martial_status' => null,
        'postal_address' => null
    ];
});

$factory->define('App\Business', function () {
    $faker = Faker\Factory::create();
    return [
        'name' => 'HGNC',
        'slug' => 'hgnc',
        'description' => $faker->paragraph,
        'timezone' => 'America/Argentina/Buenos_Aires',
        'postal_address' => '1234 Honorio Pueyrredon, Pilar, Buenos Aires, Argentina',
        'phone' => '+542304443231',
        'social_facebook' => 'https://www.facebook.com/example?fref=ts',
        'strategy' => 'dateslot',
        'plan' => 'free',
        'category_id' => 1
    ];
});

$factory->define('App\Service', function () {
    $faker = Faker\Factory::create();
    return [
        'name' => 'Instalación',
        'description' => $faker->paragraph,
        'prerequisites' => $faker->paragraph,
        'duration' => 60
    ];
});

$factory->define('App\Vacancy', function () {
    $faker = Faker\Factory::create();
    return [
        'date' => date('Y-m-d', strtotime('today +2 days')),
        'start_at' => date('Y-m-d 08:00:00', strtotime('today +2 days')),
        'finish_at' => date('Y-m-d 22:00:00', strtotime('today +2 days')),
        'capacity' => 1
    ];
});