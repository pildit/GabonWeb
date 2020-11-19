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
            'carnet-abattage',
            'management-unit',
            'permission',
            'permit',
            'roles',
            'site_logbook_items',
            'site_logbook_logs',
            'site_logbooks',
            'species',
            'translations',
            'users'
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
                Permission::create(['name' => $resource . "." . $action]);
        }
    }
}


