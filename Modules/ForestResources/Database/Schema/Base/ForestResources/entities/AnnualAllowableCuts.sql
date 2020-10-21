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
