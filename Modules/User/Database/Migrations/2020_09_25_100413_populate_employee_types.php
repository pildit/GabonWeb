<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateEmployeeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('admin.employee_types')->where('name', '=', 'Employee of Ministry')->delete();
        DB::table('admin.employee_types')->where('name', '=', 'Employee of CAF')->delete();
        DB::table('admin.employee_types')->where('name', '=', 'Employee of Concessionaire')->delete();
    }
}
