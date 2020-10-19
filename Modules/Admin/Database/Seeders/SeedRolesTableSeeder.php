<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Role;

class SeedRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $roles = ['admin', 'caf', 'forest_concessionaire', 'forester' , 'logger', 'depot_manager', 'expeditor', 'transporter', 'guest'];

        foreach ($roles as $role)
        {
            Role::create(['name' => $role]);
        }
    }
}
