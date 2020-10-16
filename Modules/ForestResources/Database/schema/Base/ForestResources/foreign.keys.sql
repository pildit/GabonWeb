--
-- "ForestResources"."BaseResourcesTable"
--

alter table "ForestResources"."BaseResourcesTable"
add constraint "FK_BaseResourcesTable_ResourceType"
    foreign key
        (
            "ResourceType"
        )
    references "ForestResources"."ResourceTypesTable"("Id")
;

--
-- "ForestResources"."DevelopmentUnitsTable"
--

alter table "ForestResources"."DevelopmentUnitsTable"
add constraint "FK_DevelopmentUnitsTable_Concession"
    foreign key
        (
            "Concession"
        )
    references "ForestResources"."ConcessionsTable"("Id")
;

--
-- "ForestResources"."DevelopmentPlansTable"
--

alter table "ForestResources"."DevelopmentPlansTable"
add constraint "FK_DevelopmentPlansTable_DevelopmentUnit"
    foreign key
        (
            "DevelopmentUnit"
        )
    references "ForestResources"."DevelopmentUnitsTable"("Id")
    -- on delete cascade   -- QUESTION: is this what we want? (disabled for now because I don't think we want this)
;

alter table "ForestResources"."DevelopmentPlansTable"
add constraint "FK_DevelopmentPlansTable_Species"
    foreign key
        (
            "Species"
        )
    references "Taxonomy"."SpeciesTable"("Id")
;

--
-- "ForestResources"."ManagementUnitsTable"
--

alter table "ForestResources"."ManagementUnitsTable"
add constraint "FK_ManagementUnitsTable_DevelopmentUnit"
    foreign key
        (
            "DevelopmentUnit"
        )
    references "ForestResources"."DevelopmentUnitsTable"("Id")
;

--
-- "ForestResources"."ManagementPlansTable"
--

alter table "ForestResources"."ManagementPlansTable"
add constraint "FK_ManagementPlansTable_Species"
    foreign key
        (
            "Species"
        )
    references "Taxonomy"."SpeciesTable"("Id")
;


alter table "ForestResources"."ManagementPlansTable"
add constraint "FK_ManagementPlansTable_ManagementUnit"
    foreign key
        (
            "ManagementUnit"
        )
    references "ForestResources"."ManagementUnitsTable"("Id")
    -- on delete cascade   -- QUESTION: is this what we want? (disabled for now because I don't think we want this)
;

--
-- "ForestResources"."AnnualAllowableCutsTable"
--

alter table "ForestResources"."AnnualAllowableCutsTable"
add constraint "FK_AnnualAllowableCutsTable_ManagementUnit"
    foreign key
        (
            "ManagementUnit"
        )
    references "ForestResources"."ManagementUnitsTable"("Id")
;


--
-- "ForestResources"."AnnualOperationPlansTable"
--

alter table "ForestResources"."AnnualOperationPlansTable"
add constraint "FK_AnnualOperationPlansTable_Species"
    foreign key
        (
            "Species"
        )
    references "Taxonomy"."SpeciesTable"("Id")
;


alter table "ForestResources"."AnnualOperationPlansTable"
add constraint "FK_AnnualOperationPlansTable_AnnualAllowableCut"
    foreign key
        (
            "AnnualAllowableCut"
        )
    references "ForestResources"."AnnualAllowableCutsTable"("Id")
    -- on delete cascade   -- QUESTION: is this what we want? (disabled for now because I don't think we want this)
;

alter table "ForestResources"."ConcessionsTable"
add constraint "FK_ConcessionTable_ConstituentPermit"
    foreign key
        (
            "ConstituentPermit"
        )
    references "ForestResources"."ConstituentPermitsTable"("Id")
;

alter table "ForestResources"."ConstituentPermitsTable"
add constraint "FK_ConstituentPermitsTable_PermitType"
    foreign key
        (
            "PermitType"
        )
    references "ForestResources"."PermitTypesTable"("Id")
;


-- TODO/BUGBUG: link this to the right table
-- alter table "ForestResources"."ConstituentPermitsTable"
-- add constraint "FK_ConstituentPermitsTable_User"
--     foreign key
--         (
--             "User"
--         )
--     references "admin"."accounts"("id")
-- ;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
add constraint "FK_AnnualAllowableCutInventory_AnnualAllowableCut"
    foreign key
        (
            "AnnualAllowableCut"
        )
    references "ForestResources"."AnnualAllowableCutsTable"("Id")
;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
add constraint "FK_AnnualAllowableCutInventory_Species"
    foreign key
        (
            "Species"
        )
    references "Taxonomy"."SpeciesTable"("Id")
;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
add constraint "FK_AnnualAllowableCutInventory_Quality"
    foreign key
        (
            "Quality"
        )
    references "ForestResources"."InventoryQualitiesTable"("Id")
;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
add constraint "FK_AnnualAllowableCutInventory_Parcel"
    foreign key
        (
            "Parcel"
        )
    references "ForestResources"."ParcelsTable"("Id")
;
