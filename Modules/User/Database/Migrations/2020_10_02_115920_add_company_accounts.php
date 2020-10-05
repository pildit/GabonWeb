<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin.accounts', function (Blueprint $table) {
            $table->integer('company_id')->nullable()->references('id')->on('admin.companies');
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
            $table->dropColumn('company_id');
        });
    }
}
