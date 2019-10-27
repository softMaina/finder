<?php

use App\ShopSize;
use Illuminate\Database\Seeder;

class ShopSizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shopSizes = [
            '10x10',
            '20x20',
            '30x30',
            '40x30',
            '50x50',
            '60x60',
            '70x70',
            '80X80',
            '90X90',
            '100X100'
        ];

        foreach ($shopSizes as $shopSize) {
            ShopSize::create([
                'size' => $shopSize
            ]);
        }
    }
}
