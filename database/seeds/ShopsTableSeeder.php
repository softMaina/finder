<?php

use App\Shop;
use App\ShopImage;
use App\User;
use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $landlords = factory(User::class, 10)->create();

        $landlords->each(function ($landlord) {
            $shops = factory(Shop::class, 5)->create([
                'owner_id' => $landlord->id,
            ]);

            $shops->each(function ($shop) {
                factory(ShopImage::class, 5)->create([
                    'shop_id' => $shop->id,
                ]);
            });
        });
    }
}
