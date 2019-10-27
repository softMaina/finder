<?php

use App\ShopStatus;
use Illuminate\Database\Seeder;

class ShopStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shopStatuses = ['Available', 'Taken'];

        foreach ($shopStatuses as $status) {
            ShopStatus::create([
                'title' => $status,
            ]);
        }
    }
}
