<?php

use Illuminate\Support\Facades\Schema;
use MStaack\LaravelPostgis\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePermitTrackingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            create table transportation."PermitTrackingTable"
            (
                "Id" serial,
                "User" int not null,
                "Permit" int not null,
                "Geometry" public.geometry not null,
                "CreatedAt" timestamp default CURRENT_TIMESTAMP,
                "UpdatedAt" timestamp default CURRENT_TIMESTAMP
            );
        ');

        /** Table view */
        DB::statement('
            create view "transportation"."PermitTracking"
            as
            select
                pt."Id",
                pt."User",
                pt."Permit",
                pt."Geometry",
                pt."CreatedAt",
                pt."UpdatedAt"
            from "transportation"."PermitTrackingTable" pt;
        ');

        DB::statement('
            create or replace rule "PermitTracking_instead_of_delete"
            as
                on delete to "transportation"."PermitTracking"
                do instead
                    delete from "transportation"."PermitTrackingTable"
                    where
                        "transportation"."PermitTrackingTable"."Id" = old."Id";
        ');

        DB::statement('
            create or replace rule "PermitTracking_instead_of_insert"
            as
                on insert to "transportation"."PermitTracking"
                do instead
                    insert into "transportation"."PermitTrackingTable"
                        ("Id", "User", "Permit", "Geometry", "CreatedAt", "UpdatedAt")
                    values
                        (
                            nextval(\'"transportation"."PermitTrackingTable_Id_seq"\'),
                            new."User",
                            new."Permit",
                            new."Geometry",
                            new."CreatedAt",
                            new."UpdatedAt"
                        )
                    returning
                        "Id",
                        "User",
                        "Permit",
                        "Geometry",
                        "CreatedAt",
                        "UpdatedAt"
            ;

        ');

        DB::statement('
            create or replace rule "PermitTracking_instead_of_update"
            as
                on update to "transportation"."PermitTracking"
                do instead
                    update "transportation"."PermitTrackingTable"
                        set
                            "User" = new."User",
                            "Geometry" = new."Geometry",
                            "UpdatedAt" = new."UpdatedAt"
                        where
                            "Id" = old."Id"
                        returning
                            "Id",
                            "User",
                            "Permit",
                            "Geometry",
                            "CreatedAt",
                            "UpdatedAt"
            ;
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PermitTrackingTable');
        DB::statement('drop view if exists "transportation"."PermitTracking"');
        DB::statement('drop rule if exists "PermitTracking_instead_of_delete"');
        DB::statement('drop rule if exists "PermitTracking_instead_of_insert"');
        DB::statement('drop rule if exists "PermitTracking_instead_of_update"');
    }
}
