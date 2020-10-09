<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EmployeeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('admin.employee_types')->insert(
            array(
                'name' => 'Employee of Ministry'
            )
        );
        DB::table('admin.employee_types')->insert(
            array(
                'name' => 'Employee of CAF'
            )
        );
        DB::table('admin.employee_types')->insert(
            array(
                'name' => 'Employee of Concessionaire'
            )
        );

        // $this->call("OthersTableSeeder");
    }
}
