-----------------------------------------
-- "ForestResources"."ManagementUnits" --
-----------------------------------------
create table "ForestResources"."ManagementUnitsTable"
(
    "DevelopmentUnit" int null,
    constraint "PK_ManagementUnitsTable" primary key ("Id")

)
inherits ("ForestResources"."BaseResourcesTable")
;

comment on table "ForestResources"."ManagementUnitsTable"
    is 'Unite Forestiere de Gestion (UFG)';


-- If you query by name, you are likely to filter by parent DevelopmentUnit as well, not just name
create index "IX_ManagementUnitsTable.Name_DevelopmentUnit"
on "ForestResources"."ManagementUnitsTable"
    (
        "Name"
        , "DevelopmentUnit"
    )
;

create index "IX_ManagementUnitsTable.DevelopmentUnit"
on "ForestResources"."ManagementUnitsTable"
    (
        "DevelopmentUnit"
    )
;


----------
-- VIEW --
----------
create view "ForestResources"."ManagementUnits"
as
    select
        mut."Id"
        , mut."Name"
        , mut."DevelopmentUnit"
        , mut."Geometry"
    from "ForestResources"."ManagementUnitsTable" as mut
;

comment on view "ForestResources"."ManagementUnits"
    is 'Unite Forestiere de Gestion (UFG)';

-----------
-- RULES --
-----------
create or replace rule "ManagementUnits_instead_of_delete"
as
    on delete to "ForestResources"."ManagementUnits"
    do instead
        delete from "ForestResources"."ManagementUnitsTable"
        where
            "ForestResources"."ManagementUnitsTable"."Id" = old."Id"
;

create or replace rule "ManagementUnits_instead_of_insert"
as
    on insert to "ForestResources"."ManagementUnits"
    do instead
        insert into "ForestResources"."ManagementUnitsTable"
            ("Id","ResourceType", "Name", "DevelopmentUnit","Geometry")
        values
            (
                nextval('"ForestResources"."SEQ_BaseResources"')
                ,(
                    select rt."Id"
                    from "ForestResources"."ResourceTypes" as rt
                    where rt."Name" = 'Management Unit'
                    limit 1)
                , new."Name"
                , new."DevelopmentUnit"
                , new."Geometry"
            )
        returning
            "Id",
            "Name",
            "DevelopmentUnit",
            "Geometry"
;

create or replace rule "ManagementUnits_instead_of_update"
as
    on update to "ForestResources"."ManagementUnits"
    do instead
        update "ForestResources"."ManagementUnitsTable"
            set
                "Name" = new."Name"
                , "DevelopmentUnit" = new."DevelopmentUnit"
                , "Geometry" = new."Geometry"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "DevelopmentUnit",
                "Geometry"
;
