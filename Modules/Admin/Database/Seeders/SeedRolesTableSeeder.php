<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Page;
use Modules\Admin\Entities\PageRole;
use Modules\Admin\Entities\Permission;
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

        $pages = Page::all();

        $permissions = Permission::all();

        foreach ($roles as $role)
        {
            $role = Role::updateOrCreate(['name' => $role]);
            if($role->name == 'admin') {
                $role->syncPermissions($permissions->pluck('name'));
                foreach ($pages as $page) {
                    PageRole::updateOrCreate(['page_id' => $page->id, 'role_id' => $role->id]);
                }
            }
        }



    }
}
