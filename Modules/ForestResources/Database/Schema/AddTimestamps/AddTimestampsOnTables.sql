-- update_timestamp function
CREATE OR REPLACE FUNCTION update_timestamp()
    RETURNS TRIGGER AS $$
BEGIN
    NEW."UpdatedAt" = now();
    RETURN NEW;
END;
$$ language 'plpgsql';

-- BaseResourcesTable
alter table "ForestResources"."BaseResourcesTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."BaseResourcesTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."BaseResourcesTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."BaseResourcesTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- DevelopmentPlansTable
alter table "ForestResources"."DevelopmentPlansTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."DevelopmentPlansTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."DevelopmentPlansTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."DevelopmentPlansTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- ManagementPlansTable
alter table "ForestResources"."ManagementPlansTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."ManagementPlansTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."ManagementPlansTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."ManagementPlansTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- AnnualAllowableCutInventoryTable
alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."AnnualAllowableCutInventoryTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- AnnualAllowableCuts
alter table "ForestResources"."AnnualAllowableCutsTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."AnnualAllowableCutsTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."AnnualAllowableCutsTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."AnnualAllowableCuts"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- InventoryQualitiesTable
alter table "ForestResources"."InventoryQualitiesTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."InventoryQualitiesTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."InventoryQualitiesTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."InventoryQualitiesTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- ConstituentPermitsTable
alter table "ForestResources"."ConstituentPermitsTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."ConstituentPermitsTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."ConstituentPermitsTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."ConstituentPermitsTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();

-- AnnualOperationPlansTable
alter table "ForestResources"."AnnualOperationPlansTable"
    add "CreatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."AnnualOperationPlansTable"
    add "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null;

alter table "ForestResources"."AnnualOperationPlansTable"
    add "DeletedAt" timestamp null;

CREATE TRIGGER user_timestamp BEFORE INSERT OR UPDATE ON "ForestResources"."AnnualOperationPlansTable"
    FOR EACH ROW EXECUTE PROCEDURE update_timestamp();
