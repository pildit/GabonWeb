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
