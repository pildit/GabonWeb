drop view if exists "ForestResources"."AnnualAllowableCutInventory";
drop view if exists "ForestResources"."AnnualAllowableCuts";
drop view if exists "ForestResources"."AnnualOperationPlans";
drop view if exists "ForestResources"."BaseResources";
drop view if exists "ForestResources"."Concessions";
drop view if exists "ForestResources"."ConstituentPermits";
drop view if exists "ForestResources"."DevelopmentPlans";
drop view if exists "ForestResources"."DevelopmentUnits";
drop view if exists "ForestResources"."InventoryQualities";
drop view if exists "ForestResources"."LogbookItems";
drop view if exists "ForestResources"."Logbooks";
drop view if exists "ForestResources"."ManagementPlans";
drop view if exists "ForestResources"."ManagementUnits";
drop view if exists "ForestResources"."Parcels";
drop view if exists "ForestResources"."PermitTypes";
drop view if exists "ForestResources"."SiteLogbookItems";
drop view if exists "ForestResources"."SiteLogbookLogs";
drop view if exists "ForestResources"."SiteLogbooks";
drop view if exists "Taxonomy"."ProductType";
drop view if exists "Taxonomy"."Species";
drop view if exists "Transportation"."Permits";
drop view if exists "Transportation"."PermitTracking";
drop view if exists "Transportation"."PermitItems";



alter table "ForestResources"."ConcessionsTable" drop constraint if exists  "FK_ConcessionTable_ConstituentPermit";

alter table "ForestResources"."ConcessionsTable" drop constraint if exists  concessionstable_accounts_id_fk;

alter table "ForestResources"."ConcessionsTable"
    drop column if exists "ConstituentPermit";


alter table "ForestResources"."ConstituentPermitsTable"
	add if not exists "Concession" int;

alter table "ForestResources"."ConstituentPermitsTable" drop constraint if exists  constituentpermitstable_concessionstable_id_fk;

alter table "ForestResources"."ConstituentPermitsTable"
	add constraint constituentpermitstable_concessionstable_id_fk
		foreign key ("Concession") references "ForestResources"."ConcessionsTable";


alter table "ForestResources"."AnnualAllowableCutInventoryTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."AnnualAllowableCutInventoryTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."AnnualAllowableCutInventoryTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "ForestResources"."AnnualAllowableCutInventoryTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);

-- alter table "ForestResources"."AnnualAllowableCutsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
-- alter table "ForestResources"."AnnualAllowableCutsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
-- alter table "ForestResources"."AnnualAllowableCutsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

alter table "ForestResources"."AnnualOperationPlansTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."AnnualOperationPlansTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."AnnualOperationPlansTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

alter table "ForestResources"."BaseResourcesTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."BaseResourcesTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."BaseResourcesTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

-- alter table "ForestResources"."ConcessionsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
-- alter table "ForestResources"."ConcessionsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
-- alter table "ForestResources"."ConcessionsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

alter table "ForestResources"."ConstituentPermitsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."ConstituentPermitsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."ConstituentPermitsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);


alter table "ForestResources"."DevelopmentPlansTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."DevelopmentPlansTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."DevelopmentPlansTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);


-- alter table "ForestResources"."DevelopmentUnitsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
-- alter table "ForestResources"."DevelopmentUnitsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
-- alter table "ForestResources"."DevelopmentUnitsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

alter table "ForestResources"."InventoryQualitiesTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."InventoryQualitiesTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."InventoryQualitiesTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

alter table "ForestResources"."LogbookItemsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."LogbookItemsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."LogbookItemsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "ForestResources"."LogbookItemsTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "ForestResources"."LogbooksTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."LogbooksTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."LogbooksTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "ForestResources"."LogbooksTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "ForestResources"."ManagementPlansTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."ManagementPlansTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."ManagementPlansTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

-- alter table "ForestResources"."ManagementUnitsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
-- alter table "ForestResources"."ManagementUnitsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
-- alter table "ForestResources"."ManagementUnitsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);


-- alter table "ForestResources"."ParcelsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
-- alter table "ForestResources"."ParcelsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
-- alter table "ForestResources"."ParcelsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);

alter table "ForestResources"."PermitTypesTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."PermitTypesTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."PermitTypesTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);


alter table "ForestResources"."SiteLogbookItemsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbookItemsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbookItemsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbookItemsTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "ForestResources"."SiteLogbookLogsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbookLogsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbookLogsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbookLogsTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "ForestResources"."SiteLogbooksTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbooksTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbooksTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "ForestResources"."SiteLogbooksTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "Taxonomy"."ProductTypeTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "Taxonomy"."ProductTypeTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "Taxonomy"."ProductTypeTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);



alter table "Taxonomy"."SpeciesTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "Taxonomy"."SpeciesTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "Taxonomy"."SpeciesTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);


alter table "public"."log_entries" alter column "logged_at" type timestamp(0) using "logged_at"::timestamp(0);

alter table "Transportation"."PermitsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "Transportation"."PermitsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "Transportation"."PermitsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "Transportation"."PermitsTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "Transportation"."PermitTrackingTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "Transportation"."PermitTrackingTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);
alter table "Transportation"."PermitTrackingTable" alter column "ObserveAt" type timestamp(0) using "ObserveAt"::timestamp(0);


alter table "Transportation"."PermitItemsTable" alter column "CreatedAt" type timestamp(0) using "CreatedAt"::timestamp(0);
alter table "Transportation"."PermitItemsTable" alter column "DeletedAt" type timestamp(0) using "DeletedAt"::timestamp(0);
alter table "Transportation"."PermitItemsTable" alter column "UpdatedAt" type timestamp(0) using "UpdatedAt"::timestamp(0);






