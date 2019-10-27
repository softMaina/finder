<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Admin', 'Tenant', 'Landlord'];
        $roleDescriptions = ['The Administrator', 'The tenant', 'Shop Owner'];

        foreach($roles as $key => $role) {
            $record = Role::create([
                'name' => $role,
                'guard_name' => 'web',
                'description' => $roleDescriptions[$key],
            ]);
        }
    }
}
