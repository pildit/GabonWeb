----------
-- VIEW --
----------
create view "ForestResources"."AnnualAllowableCuts"
as
    select
        mut."Id"
        , mut."Name"
        , mut."ManagementUnit"
        , mut."Geometry"
    from "ForestResources"."AnnualAllowableCutsTable" as mut
;

comment on view "ForestResources"."AnnualAllowableCuts"
    is 'Assiette Anuelle de Coupe';

create table "ForestResources"."AnnualAllowableCutInventoryTable"
(
    "Id" int not null,
    "AnnualAllowableCut" int not null,
    "Species" int not null,
    "Quality" int not null,
    "Parcel" int not null,
    "TreeId" text not null,
    "DiameterBreastHeight" decimal(8,3) not null,
    "Geometry" polygon not null,
    constraint "PK_AnnualAllowableCutInventoryTable" primary key("Id"),
    constraint "CHK_AnnualAllowableCutInventoryTable.TreeId" check (length("TreeId") > 0),
    constraint "CHK_AnnualAllowableCutInventoryTable.DiameterBreastHeight" check ("DiameterBreastHeight" >= 0),
    constraint "UNIQ_AnnualAllowableCutInventoryTable.AnnualAllowableCut_TreeId" unique ("AnnualAllowableCut", "TreeId")
)
;

create sequence if not exists "ForestResources"."SEQ_AnnualAllowableCutInventory"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."AnnualAllowableCutInventoryTable"."Id"
;

create index "IX_AnnualAllowableCutInventoryTable.AnnualAllowableCut_Species"
on "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "AnnualAllowableCut"
        , "Species"
    )
;

create index "IX_AnnualAllowableCutInventoryTable.AnnualAllowableCut_TreeId"
on "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "AnnualAllowableCut"
        , "TreeId"
    )
;

create index "IX_AnnualAllowableCutInventoryTable.AnnualAllowableCut"
on "ForestResources"."AnnualAllowableCutInventoryTable"
    (
        "AnnualAllowableCut"
    )
;


----------
-- VIEW --
----------
create view "ForestResources"."AnnualAllowableCutInventory"
as
    select
        aacit."Id",
        aacit."AnnualAllowableCut",
        aacit."Species",
        aacit."Quality",
        aacit."Parcel",
        aacit."TreeId",
        aacit."DiameterBreastHeight",
        aacit."Geometry"
    from "ForestResources"."AnnualAllowableCutInventoryTable" as aacit
;

-----------
-- RULES --
-----------
create or replace rule "AnnualAllowableCutInventory_instead_of_delete"
as
    on delete to "ForestResources"."AnnualAllowableCutInventory"
    do instead
        delete from "ForestResources"."AnnualAllowableCutInventoryTable"
        where
            "ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id"
;

create or replace rule "AnnualAllowableCutInventory_instead_of_insert"
as
    on insert to "ForestResources"."AnnualAllowableCutInventory"
    do instead
        insert into "ForestResources"."AnnualAllowableCutInventoryTable"
            (
                "Id",
                "AnnualAllowableCut",
                "Species",
                "Quality",
                "Parcel",
                "TreeId",
                "DiameterBreastHeight",
                "Geometry"
            )
        values
            (
                nextval('"ForestResources"."SEQ_AnnualAllowableCutInventory"'),
                new."AnnualAllowableCut",
                new."Species",
                new."Quality",
                new."Parcel",
                new."TreeId",
                new."DiameterBreastHeight",
                new."Geometry"
            )
        returning
                "Id",
                "AnnualAllowableCut",
                "Species",
                "Quality",
                "Parcel",
                "TreeId",
                "DiameterBreastHeight",
                "Geometry"
;

create or replace rule "AnnualAllowableCutInventory_instead_of_update"
as
    on update to "ForestResources"."AnnualAllowableCutInventory"
    do instead
        update "ForestResources"."AnnualAllowableCutInventoryTable"
            set
                "AnnualAllowableCut" = new."AnnualAllowableCut",
                "Species" = new."Species",
                "Quality" = new."Quality",
                "Parcel" = new."Parcel",
                "TreeId" = new."TreeId",
                "DiameterBreastHeight" = new."DiameterBreastHeight",
                "Geometry" = new."Geometry"
            where
                "Id" = old."Id"
        returning
                "Id",
                "AnnualAllowableCut",
                "Species",
                "Quality",
                "Parcel",
                "TreeId",
                "DiameterBreastHeight",
                "Geometry"
;
