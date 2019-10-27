<?php

use App\ShopLocation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(ShopLocationsTableSeeder::class);
        $this->call(ShopSizesTableSeeder::class);
        $this->call(ShopStatusesTableSeeder::class);
        $this->call(PropertyTypesTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
