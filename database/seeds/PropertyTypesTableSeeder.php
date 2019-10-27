<?php

use App\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertyTypes = ['House/Villa', 'Flat', 'Plot/Land', 'Office Space', 'Shop/Showroom', 'Commercial Land', 'WareHouse/Godown', 'Industial Building'];

        foreach ($propertyTypes as $type) {
            PropertyType::create([
                'title' => $type,
            ]);
        }
    }
}
