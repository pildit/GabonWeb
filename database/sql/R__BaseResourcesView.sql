create or replace view "ForestResources"."BaseResources"
            ("Id", "ResourceType", "Name", "Geometry", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT brt."Id",
       brt."ResourceType",
       brt."Name",
       brt."Geometry",
       brt."CreatedAt",
       brt."UpdatedAt",
       brt."DeletedAt"
FROM "ForestResources"."BaseResourcesTable" brt;

-- TODO here we have to recreate the triggers
-- drop function if exists "ForestResources"."BaseResources_insteadof_delete"();
-- drop function if exists "ForestResources"."BaseResources_insteadof_insert"();
-- drop function if exists "ForestResources"."BaseResources_insteadof_update"();
--
-- create trigger "TRIG_ForestResources.BaseResources_insteadof_delete"
--     after delete
--     on "ForestResources"."BaseResources"
--     for each row
-- execute procedure "ForestResources"."BaseResources_insteadof_delete"();
--
-- create trigger "TRIG_ForestResources.BaseResources_insteadof_insert"
--     after insert
--     on "ForestResources"."BaseResources"
--     for each row
-- execute procedure "ForestResources"."BaseResources_insteadof_insert"();
--
-- create trigger "TRIG_ForestResources.BaseResources_insteadof_update"
--     after update
--     on "ForestResources"."BaseResources"
--     for each row
-- execute procedure "ForestResources"."BaseResources_insteadof_update"();
--
