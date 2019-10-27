<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ShopLocation;
use Faker\Generator as Faker;

$factory->define(ShopLocation::class, function (Faker $faker) {
    return [
        'address_1' => $faker->city,
        'location' => $faker->address
    ];
});
