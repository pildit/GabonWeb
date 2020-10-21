drop view if exists "ForestResources"."AnnualAllowableCutInventory";
alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    alter column "Geometry" type geometry(Point,5223) using "Geometry"::geometry(Point,5223);

drop view if exists "ForestResources"."BaseResources";
drop view if exists "ForestResources"."AnnualAllowableCuts";
drop view if exists "ForestResources"."Concessions";
drop view if exists "ForestResources"."DevelopmentUnits";
drop view if exists "ForestResources"."ManagementUnits";
drop view if exists "ForestResources"."Parcels";
alter table "ForestResources"."BaseResourcesTable"
    alter column "Geometry" type geometry(Polygon,5223) using "Geometry"::geometry(Polygon,5223);


drop view if exists "ForestResources"."ConstituentPermits";
alter table "ForestResources"."ConstituentPermitsTable"
    alter column "Geometry" type geometry(Polygon,5223) using "Geometry"::geometry(Polygon,5223);
