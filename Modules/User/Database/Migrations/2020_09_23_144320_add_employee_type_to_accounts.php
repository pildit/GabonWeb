<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeTypeToAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin.accounts', function (Blueprint $table) {
            $table->integer('employee_type')->nullable()->unsigned()->references('id')->on('admin.employee_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin.accounts', function (Blueprint $table) {
            $table->dropColumn('employee_type');
        });
    }
}
