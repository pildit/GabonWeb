<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

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
                'name' => 'Ministry'
            )
        );
        DB::table('admin.employee_types')->insert(
            array(
                'name' => 'L\'Agence'
            )
        );
        DB::table('admin.employee_types')->insert(
            array(
                'name' => 'Concessionaire'
            )
        );

        // $this->call("OthersTableSeeder");
    }
}
