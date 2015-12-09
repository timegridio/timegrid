<?php

//////////
// User //
//////////

$factory('App\Models\User', [
    'username' => $faker->firstName,
    'name'     => $faker->firstName,
    'email'    => $faker->safeEmail,
    'password' => bcrypt('password'),
]);

//////////
// Role //
//////////

$factory('App\Models\Role', function ($faker) {
    $name = $faker->word;

    return [
        'name'        => $faker->word,
        'slug'        => str_slug($name),
        'description' => $faker->sentence,
    ];
});

/////////////
// Contact //
/////////////

$factory('App\Models\Contact', [
    'firstname'      => $faker->firstName,
    'lastname'       => $faker->lastName,
    'nin'            => $faker->numberBetween(25000000, 50000000),
    'email'          => $faker->safeEmail,
    'birthdate'      => Carbon\Carbon::now()->subYears(30)->format('m/d/Y'),
    'mobile'         => null,
    'mobile_country' => null,
    'gender'         => $faker->randomElement(['M', 'F']),
    'occupation'     => $faker->title,
    'martial_status' => null,
    'postal_address' => $faker->address,
]);

//////////////
// Business //
//////////////

$factory('App\Models\Business', [
    'name'            => $faker->sentence(3),
    'description'     => $faker->paragraph,
    'timezone'        => $faker->timezone,
    'postal_address'  => $faker->address,
    'phone'           => null,
    'social_facebook' => 'https://www.facebook.com/example?fref=ts',
    'strategy'        => 'dateslot',
    'plan'            => 'free',
    'category_id'     => $faker->randomElement([1, 2, 3]),
]);

/////////////
// Service //
/////////////

$factory('App\Models\Service', [
    'business_id'   => 'factory:App\Models\Business',
    'name'          => $faker->sentence(2),
    'description'   => $faker->paragraph,
    'prerequisites' => $faker->paragraph,
    'duration'      => $faker->randomElement([15, 30, 60, 120]),
]);

/////////////
// Vacancy //
/////////////

$factory('App\Models\Vacancy', function ($faker) {
    $dateTime = $faker->dateTimeBetween('today', 'today +7 days')->format('Y-m-d H:i:s');

    return [
        'business_id' => 'factory:App\Models\Business',
        'service_id'  => 'factory:App\Models\Service',
        'date'        => Carbon\Carbon::parse($dateTime)->toDateTimeString(),
        'start_at'    => date('Y-m-d 00:00:00', strtotime($dateTime)),
        'finish_at'   => date('Y-m-d 23:00:00', strtotime($dateTime)),
        'capacity'    => 1,
    ];
});

/////////////////
// Appointment //
/////////////////

$factory('App\Models\Appointment', function ($faker) {
    $startAt = $faker->dateTimeBetween('today', 'today +7 days')->format('Y-m-d H:i:s');

    return [
        'business_id' => 'factory:App\Models\Business',
        'contact_id'  => 'factory:App\Models\Contact',
        'service_id'  => 'factory:App\Models\Service',
        'vacancy_id'  => 'factory:App\Models\Vacancy',
        'status'      => $faker->randomElement(['R', 'C', 'A', 'S']),
        'start_at'    => Carbon\Carbon::parse($startAt),
        'duration'    => $faker->randomElement([15, 30, 60, 120]),
        'comments'    => $faker->sentence,
    ];
});
