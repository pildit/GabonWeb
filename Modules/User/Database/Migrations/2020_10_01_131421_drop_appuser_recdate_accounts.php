<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAppuserRecdateAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (Schema::hasColumn('admin.accounts', 'appuser'))
            Schema::table('admin.accounts', function (Blueprint $table) {
                $table->dropColumn('appuser');
            });
            

        if (Schema::hasColumn('admin.accounts', 'recdate'))
            Schema::table('admin.accounts', function (Blueprint $table) {
                $table->dropColumn('recdate');
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
            $table->string('appuser');
            $table->timestamp('recdate');
        });
    }
}
