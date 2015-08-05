<?php // app/database/factories/ModelFactory.php

$factory->define('App\Business', function () {
    return [
        'name' => 'HGNC',
        'slug' => 'hgnc',
        'description' => $faker->paragraph,
        'timezone' => 'America/Argentina/Buenos_Aires',
        'postal_address' => '1124 Honorio Pueyrredon, Pilar, Buenos Aires, Argentina',
        'phone' => '+542304433250',
        'social_facebook' => 'https://www.facebook.com/HernanGncMecanicaIntegral?fref=ts',
        'strategy' => 'dateslot',
        'plan' => 'free',
        'category_id' => 1
    ];
});

$factory->define('App\Service', function () {
    return [
        'name' => 'Instalación',
        'description' => $faker->paragraph,
        'prerequisites' => $faker->paragraph,
        'duration' => 60,
    ];
});