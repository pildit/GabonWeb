alter table "ForestResources"."AnnualAllowableCutsTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_BaseResources"'::regclass);

alter table "ForestResources"."ConcessionsTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_BaseResources"'::regclass);

alter table "ForestResources"."DevelopmentUnitsTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_BaseResources"'::regclass);

alter table "ForestResources"."ManagementUnitsTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_BaseResources"'::regclass);

alter table "ForestResources"."ParcelsTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_BaseResources"'::regclass);

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_AnnualAllowableCutInventory"'::regclass);

alter table "ForestResources"."AnnualOperationPlansTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_AnnualOperationPlans"'::regclass);

alter table "ForestResources"."ConstituentPermitsTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_ConstituentPermits"'::regclass);

alter table "ForestResources"."DevelopmentPlansTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_DevelopmentPlans"'::regclass);

alter table "ForestResources"."InventoryQualitiesTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_InventoryQualities"'::regclass);

alter table "ForestResources"."ManagementPlansTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_ManagementPlans"'::regclass);

alter table "ForestResources"."DevelopmentPlansTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_DevelopmentPlans"'::regclass);

alter table "ForestResources"."PermitTypesTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_PermitTypes"'::regclass);

alter table "ForestResources"."ResourceTypesTable"
    alter column "Id" set default nextval('"ForestResources"."SEQ_ResourceTypes"'::regclass);

alter table "Taxonomy"."SpeciesTable"
    alter column "Id" set default nextval('"Taxonomy"."SEQ_Species"'::regclass);





