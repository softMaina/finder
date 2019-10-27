<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PropertyType;
use App\Shop;
use App\ShopImage;
use App\ShopLocation;
use App\ShopSize;
use App\ShopStatus;
use App\User;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'owner_id' => factory(User::class)->create()->id,
        'name' => $faker->name,
        'description' => $faker->paragraph(8),
        'shop_location_id' => factory(ShopLocation::class)->create()->id,
        'shop_size_id' => ShopSize::all()->random()->id,
        'shop_status_id' => ShopStatus::all()->random()->id,
        'price' => $faker->numberBetween($min = 1000, $max = 9000),
        'shop_type_id' => PropertyType::all()->random()->id,
    ];
});
