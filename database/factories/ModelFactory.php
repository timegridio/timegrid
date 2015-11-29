<?php // app/database/factories/ModelFactory.php

$factory->define('App\User', function () {
    $faker = Faker\Factory::create();
    return [
        'name' => $faker->firstName,
        'email' => $faker->safeEmail,
        'password' => bcrypt('stubpassword')
    ];
});

$factory->define('App\Contact', function () {
    $faker = Faker\Factory::create();
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'nin' => $faker->numberBetween(25000000, 50000000),
        'email' => $faker->safeEmail,
        'birthdate' => $faker->dateTimeThisCentury->format('m/d/Y'),
        'mobile' => null,
        'mobile_country' => null,
        'gender' => $faker->randomElement(['M', 'F']),
        'occupation' => $faker->title,
        'martial_status' => null,
        'postal_address' => $faker->address
    ];
});

$factory->define('App\Business', function () {
    $faker = Faker\Factory::create();
    $businessName = $faker->sentence(3);
    $businessSlug = str_slug($businessName, '-');
    return [
        'name' => $faker->sentence(3),
        'slug' => $businessSlug,
        'description' => $faker->paragraph,
        'timezone' => $faker->timezone,
        'postal_address' => $faker->address,
        'phone' => null,
        'social_facebook' => 'https://www.facebook.com/example?fref=ts',
        'strategy' => 'dateslot',
        'plan' => 'free',
        'category_id' => $faker->randomElement([1, 2, 3])
    ];
});

$factory->define('App\Service', function () {
    $faker = Faker\Factory::create();
    return [
        'name' => $faker->sentence(2),
        'description' => $faker->paragraph,
        'prerequisites' => $faker->paragraph,
        'duration' => $faker->randomElement([15, 30, 60, 120])
    ];
});

$factory->define('App\Vacancy', function () {
    $faker = Faker\Factory::create();
    $date = $faker->dateTimeBetween('today', 'today +7 days')->format('Y-m-d');
    return [
        'date' => date('Y-m-d', strtotime($date)),
        'start_at' => date('Y-m-d 08:00:00', strtotime($date)),
        'finish_at' => date('Y-m-d 22:00:00', strtotime($date)),
        'capacity' => 1
    ];
});

$factory->define('App\Appointment', function () {
    $faker = Faker\Factory::create();
    return [
        'business_id' => factory(App\Business::class)->make()->id,
        'contact_id' => factory(App\Contact::class)->make()->id,
        'service_id' => factory(App\Service::class)->make()->id,
        'vacancy_id' => null,
        'status' => $faker->randomElement(['R', 'C', 'A', 'S']),
        'start_at' => Carbon::parse(date('Y-m-d 08:00:00', strtotime('today +2 days'))),
        'duration' => $faker->randomElement([15, 30, 60, 120]),
        'comments' => $faker->sentence
    ];
});
