-----------------------------------------
-- "ForestResources"."AnnualAllowableCuts" --
-----------------------------------------
create table "ForestResources"."AnnualAllowableCutsTable"
(
    "ManagementUnit" int null,
    constraint "PK_AnnualAllowableCutsTable" primary key ("Id")

)
inherits ("ForestResources"."BaseResourcesTable")
;

comment on table "ForestResources"."AnnualAllowableCutsTable"
    is 'Assiette Anuelle de Coupe';


-- If you query by name, you are likely to filter by parent ManagementUnit as well, not just name
create index "IX_AnnualAllowableCutsTable.Name_ManagementUnit"
on "ForestResources"."AnnualAllowableCutsTable"
    (
        "Name"
        , "ManagementUnit"
    )
;

create index "IX_AnnualAllowableCutsTable.ManagementUnit"
on "ForestResources"."AnnualAllowableCutsTable"
    (
        "ManagementUnit"
    )
;


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

-----------
-- RULES --
-----------
create or replace rule "AnnualAllowableCuts_instead_of_delete"
as
    on delete to "ForestResources"."AnnualAllowableCuts"
    do instead
        delete from "ForestResources"."AnnualAllowableCutsTable"
        where
            "ForestResources"."AnnualAllowableCutsTable"."Id" = old."Id"
;

create or replace rule "AnnualAllowableCuts_instead_of_insert"
as
    on insert to "ForestResources"."AnnualAllowableCuts"
    do instead
        insert into "ForestResources"."AnnualAllowableCutsTable"
            ("Id","ResourceType", "Name", "ManagementUnit","Geometry")
        values
            (
                nextval('"ForestResources"."SEQ_BaseResources"')
                ,(
                    select rt."Id"
                    from "ForestResources"."ResourceTypes" as rt
                    where rt."Name" = 'Annual Allowable Cut'
                    limit 1)
                , new."Name"
                , new."ManagementUnit"
                , new."Geometry"
            )
        returning
            "Id",
            "Name",
            "ManagementUnit",
            "Geometry"
;

create or replace rule "AnnualAllowableCuts_instead_of_update"
as
    on update to "ForestResources"."AnnualAllowableCuts"
    do instead
        update "ForestResources"."AnnualAllowableCutsTable"
            set
                "Name" = new."Name"
                , "ManagementUnit" = new."ManagementUnit"
                , "Geometry" = new."Geometry"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "ManagementUnit",
                "Geometry"
;
