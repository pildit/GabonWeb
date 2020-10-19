----------
-- VIEW --
----------

DROP VIEW "ForestResources"."AnnualAllowableCuts";


CREATE VIEW "ForestResources"."AnnualAllowableCuts"
as
    SELECT mut."Id",
    mut."Name",
    mut."AacId",
    mut."ManagementUnit",
    mut."ManagementPlan",
    mut."Geometry",
    mut."CreatedAt",
    mut."UpdatedAt",
    mut."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutsTable" as mut;

-----------
-- RULES --
-----------

CREATE RULE "AnnualAllowableCuts_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD  INSERT INTO "ForestResources"."AnnualAllowableCutsTable" ("Id", "ResourceType", "Name", "AacId", "ManagementUnit", "ManagementPlan", "Geometry", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass), ( SELECT rt."Id"
           FROM "ForestResources"."ResourceTypes" rt
          WHERE (rt."Name" = 'Annual Allowable Cut'::text)
         LIMIT 1), new."Name", new."AacId", new."ManagementUnit", new."ManagementPlan", new."Geometry", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."AnnualAllowableCutsTable"."Id",
    "ForestResources"."AnnualAllowableCutsTable"."Name",
    "ForestResources"."AnnualAllowableCutsTable"."AacId",
    "ForestResources"."AnnualAllowableCutsTable"."ManagementUnit",
    "ForestResources"."AnnualAllowableCutsTable"."ManagementPlan",
    "ForestResources"."AnnualAllowableCutsTable"."Geometry",
    "ForestResources"."AnnualAllowableCutsTable"."CreatedAt",
    "ForestResources"."AnnualAllowableCutsTable"."UpdatedAt",
    "ForestResources"."AnnualAllowableCutsTable"."DeletedAt";


CREATE RULE "AnnualAllowableCuts_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD  UPDATE "ForestResources"."AnnualAllowableCutsTable" SET "Name" = new."Name", "AacId" = new."AacId", "ManagementUnit" = new."ManagementUnit", "ManagementPlan" = new."ManagementPlan", "Geometry" = new."Geometry", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."AnnualAllowableCutsTable"."Id" = old."Id")
  RETURNING "ForestResources"."AnnualAllowableCutsTable"."Id",
    "ForestResources"."AnnualAllowableCutsTable"."Name",
    "ForestResources"."AnnualAllowableCutsTable"."AacId",
    "ForestResources"."AnnualAllowableCutsTable"."ManagementUnit",
    "ForestResources"."AnnualAllowableCutsTable"."ManagementPlan",
    "ForestResources"."AnnualAllowableCutsTable"."Geometry",
    "ForestResources"."AnnualAllowableCutsTable"."CreatedAt",
    "ForestResources"."AnnualAllowableCutsTable"."UpdatedAt",
    "ForestResources"."AnnualAllowableCutsTable"."DeletedAt";

CREATE RULE "AnnualAllowableCuts_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD  DELETE FROM  "ForestResources"."AnnualAllowableCutsTable"
  WHERE ( "ForestResources"."AnnualAllowableCutsTable"."Id" = old."Id");
