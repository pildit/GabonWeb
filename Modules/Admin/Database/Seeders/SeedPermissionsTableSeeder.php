<?php


namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Permission;
use Modules\Admin\Entities\Role;

class SeedPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $resources = [
            'concession',
            'constituent-permit',
            'AAC',
            'AACInventory',
            'development-unit',
            'logbook',
            'management-unit',
            'permission',
            'permit',
            'roles',
            'site_logbook',
            'species',
            'translations',
            'users',
            'parcels',
            'companies',
            'permit-types',
            'quality',
            'product-types'
         ];

        $actions = [
            'view',
            'add',
            'edit',
            'approve',
            'delete'
        ];

        foreach ($resources as $resource) {
            foreach ($actions as $action)
                Permission::updateOrCreate(['name' => $resource . "." . $action]);
        }
    }
}


