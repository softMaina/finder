<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ShopImage;
use Faker\Generator as Faker;

$factory->define(ShopImage::class, function (Faker $faker) {
    return [
        'path' => $faker->imageUrl($width = 640, $height = 480)
    ];
});
