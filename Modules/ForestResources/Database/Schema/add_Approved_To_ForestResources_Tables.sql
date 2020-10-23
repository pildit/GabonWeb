ALTER TABLE "ForestResources"."AnnualAllowableCutInventoryTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."AnnualAllowableCutsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."AnnualOperationPlansTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."ConcessionsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."ConstituentPermitsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."DevelopmentPlansTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."DevelopmentUnitsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."ManagementPlansTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."ManagementUnitsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."ParcelsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."LogbooksTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."SiteLogbooksTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."LogbookItemsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."SiteLogbookItemsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

ALTER TABLE "ForestResources"."SiteLogbookLogsTable"
ADD COLUMN   "Approved" bool DEFAULT FALSE;

DROP VIEW "ForestResources"."AnnualAllowableCutInventory";

CREATE VIEW "ForestResources"."AnnualAllowableCutInventory"
as
    SELECT aacit."Id",
    aacit."AnnualAllowableCut",
    aacit."Species",
    aacit."Quality",
    aacit."Parcel",
    aacit."TreeId",
    aacit."DiameterBreastHeight",
    aacit."Geometry",
    aacit."Approved",
    aacit."CreatedAt",
    aacit."UpdatedAt",
    aacit."DeletedAt"
   FROM "ForestResources"."AnnualAllowableCutInventoryTable" aacit;

CREATE RULE "AnnualAllowableCutInventory_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  INSERT INTO "ForestResources"."AnnualAllowableCutInventoryTable" ("Id", "AnnualAllowableCut", "Species", "Quality", "Parcel", "TreeId", "DiameterBreastHeight", "Geometry", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_AnnualAllowableCutInventory"'::regclass), new."AnnualAllowableCut", new."Species", new."Quality", new."Parcel", new."TreeId", new."DiameterBreastHeight", new."Geometry", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."AnnualAllowableCutInventoryTable"."Id",
    "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Species",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Quality",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Parcel",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."TreeId",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Geometry",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Approved",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."CreatedAt",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."UpdatedAt",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."DeletedAt";



CREATE RULE "AnnualAllowableCutInventory_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  UPDATE "ForestResources"."AnnualAllowableCutInventoryTable" SET "AnnualAllowableCut" = new."AnnualAllowableCut", "Species" = new."Species", "Quality" = new."Quality", "Parcel" = new."Parcel", "TreeId" = new."TreeId", "DiameterBreastHeight" = new."DiameterBreastHeight", "Geometry" = new."Geometry", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id")
  RETURNING "ForestResources"."AnnualAllowableCutInventoryTable"."Id",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Species",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Quality",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Parcel",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."TreeId",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Geometry",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."Approved",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."CreatedAt",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."UpdatedAt",
                                                                                 "ForestResources"."AnnualAllowableCutInventoryTable"."DeletedAt";

CREATE RULE "AnnualAllowableCutInventory_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  DELETE FROM "ForestResources"."AnnualAllowableCutInventoryTable"
  WHERE ("ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id");


DROP VIEW "ForestResources"."AnnualAllowableCuts";
CREATE VIEW "ForestResources"."AnnualAllowableCuts"
as
SELECT mut."Id",
    mut."Name",
    mut."AacId",
    mut."ManagementUnit",
    mut."ManagementPlan",
    mut."Geometry",
    mut."Approved",
    mut."CreatedAt",
    mut."UpdatedAt",
    mut."DeletedAt"
   FROM "ForestResources"."AnnualAllowableCutsTable" mut;

CREATE RULE "AnnualAllowableCuts_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD  INSERT INTO "ForestResources"."AnnualAllowableCutsTable" ("Id", "ResourceType", "Name", "AacId", "ManagementUnit", "ManagementPlan", "Geometry", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass), ( SELECT rt."Id"
           FROM "ForestResources"."ResourceTypes" rt
          WHERE (rt."Name" = 'Annual Allowable Cut'::text)
         LIMIT 1), new."Name", new."AacId", new."ManagementUnit", new."ManagementPlan", new."Geometry", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."AnnualAllowableCutsTable"."Id",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."Name",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."AacId",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."ManagementUnit",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."ManagementPlan",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."Geometry",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."Approved",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."CreatedAt",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."UpdatedAt",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."DeletedAt";

CREATE RULE "AnnualAllowableCuts_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD  UPDATE "ForestResources"."AnnualAllowableCutsTable" SET "Name" = new."Name", "AacId" = new."AacId", "ManagementUnit" = new."ManagementUnit", "ManagementPlan" = new."ManagementPlan", "Geometry" = new."Geometry", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."AnnualAllowableCutsTable"."Id" = old."Id")
  RETURNING "ForestResources"."AnnualAllowableCutsTable"."Id",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."Name",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."AacId",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."ManagementUnit",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."ManagementPlan",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."Geometry",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."Approved",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."CreatedAt",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."UpdatedAt",
                                                                         "ForestResources"."AnnualAllowableCutsTable"."DeletedAt";


CREATE RULE "AnnualAllowableCuts_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD  DELETE FROM "ForestResources"."AnnualAllowableCutsTable"
  WHERE ("ForestResources"."AnnualAllowableCutsTable"."Id" = old."Id");


DROP VIEW "ForestResources"."AnnualOperationPlans";

CREATE VIEW "ForestResources"."AnnualOperationPlans"
as
 SELECT aopt."Id",
    aopt."AnnualAllowableCut",
    aopt."Species",
    aopt."ExploitableVolume",
    aopt."NonExploitableVolume",
    aopt."VolumePerHectare",
    aopt."AverageVolume",
    aopt."TotalVolume",
    aopt."Approved",
    aopt."CreatedAt",
    aopt."UpdatedAt",
    aopt."DeletedAt"
   FROM "ForestResources"."AnnualOperationPlansTable" aopt;


CREATE RULE "AnnualOperationPlans_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualOperationPlans" DO INSTEAD  INSERT INTO "ForestResources"."AnnualOperationPlansTable" ("Id", "AnnualAllowableCut", "Species", "ExploitableVolume", "NonExploitableVolume", "VolumePerHectare", "AverageVolume", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_AnnualOperationPlans"'::regclass), new."AnnualAllowableCut", new."Species", new."ExploitableVolume", new."NonExploitableVolume", new."VolumePerHectare", new."AverageVolume", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."AnnualOperationPlansTable"."Id",
                                                                          "ForestResources"."AnnualOperationPlansTable"."AnnualAllowableCut",
                                                                          "ForestResources"."AnnualOperationPlansTable"."Species",
                                                                          "ForestResources"."AnnualOperationPlansTable"."ExploitableVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."NonExploitableVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."VolumePerHectare",
                                                                          "ForestResources"."AnnualOperationPlansTable"."AverageVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."TotalVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."Approved",
                                                                          "ForestResources"."AnnualOperationPlansTable"."CreatedAt",
                                                                          "ForestResources"."AnnualOperationPlansTable"."UpdatedAt",
                                                                          "ForestResources"."AnnualOperationPlansTable"."DeletedAt";

CREATE RULE "AnnualOperationPlans_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualOperationPlans" DO INSTEAD  UPDATE "ForestResources"."AnnualOperationPlansTable" SET "AnnualAllowableCut" = new."AnnualAllowableCut", "Species" = new."Species", "ExploitableVolume" = new."ExploitableVolume", "NonExploitableVolume" = new."NonExploitableVolume", "VolumePerHectare" = new."VolumePerHectare", "AverageVolume" = new."AverageVolume", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."AnnualOperationPlansTable"."Id" = old."Id")
  RETURNING "ForestResources"."AnnualOperationPlansTable"."Id",
                                                                          "ForestResources"."AnnualOperationPlansTable"."AnnualAllowableCut",
                                                                          "ForestResources"."AnnualOperationPlansTable"."Species",
                                                                          "ForestResources"."AnnualOperationPlansTable"."ExploitableVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."NonExploitableVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."VolumePerHectare",
                                                                          "ForestResources"."AnnualOperationPlansTable"."AverageVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."TotalVolume",
                                                                          "ForestResources"."AnnualOperationPlansTable"."Approved",
                                                                          "ForestResources"."AnnualOperationPlansTable"."CreatedAt",
                                                                          "ForestResources"."AnnualOperationPlansTable"."UpdatedAt",
                                                                          "ForestResources"."AnnualOperationPlansTable"."DeletedAt";


CREATE RULE "AnnualOperationPlans_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualOperationPlans" DO INSTEAD  DELETE FROM "ForestResources"."AnnualOperationPlansTable"
  WHERE ("ForestResources"."AnnualOperationPlansTable"."Id" = old."Id");


DROP VIEW "ForestResources"."Concessions";

CREATE VIEW "ForestResources"."Concessions"
as
SELECT ct."Id",
    ct."Name",
    ct."Continent",
    ct."ConstituentPermit",
    ct."Geometry",
    ct."Company",
    ct."Approved",
    ct."CreatedAt",
    ct."UpdatedAt",
    ct."DeletedAt"
   FROM "ForestResources"."ConcessionsTable" ct;

CREATE RULE "Concessions_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Concessions" DO INSTEAD  INSERT INTO "ForestResources"."ConcessionsTable" ("Id", "ResourceType", "Name", "Continent", "ConstituentPermit", "Geometry", "Company", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass), ( SELECT rt."Id"
           FROM "ForestResources"."ResourceTypes" rt
          WHERE (rt."Name" = 'Concession'::text)
         LIMIT 1), new."Name", new."Continent", new."ConstituentPermit", new."Geometry", new."Company", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."ConcessionsTable"."Id",
                                                                 "ForestResources"."ConcessionsTable"."Name",
                                                                 "ForestResources"."ConcessionsTable"."Continent",
                                                                 "ForestResources"."ConcessionsTable"."ConstituentPermit",
                                                                 "ForestResources"."ConcessionsTable"."Geometry",
                                                                 "ForestResources"."ConcessionsTable"."Company",
                                                                 "ForestResources"."ConcessionsTable"."Approved",
                                                                 "ForestResources"."ConcessionsTable"."CreatedAt",
                                                                 "ForestResources"."ConcessionsTable"."UpdatedAt",
                                                                 "ForestResources"."ConcessionsTable"."DeletedAt";


CREATE RULE "Concessions_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Concessions" DO INSTEAD  UPDATE "ForestResources"."ConcessionsTable" SET "Name" = new."Name", "Continent" = new."Continent", "ConstituentPermit" = new."ConstituentPermit", "Geometry" = new."Geometry", "Company" = new."Company", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."ConcessionsTable"."Id" = old."Id")
  RETURNING "ForestResources"."ConcessionsTable"."Id",
                                                                 "ForestResources"."ConcessionsTable"."Name",
                                                                 "ForestResources"."ConcessionsTable"."Continent",
                                                                 "ForestResources"."ConcessionsTable"."ConstituentPermit",
                                                                 "ForestResources"."ConcessionsTable"."Geometry",
                                                                 "ForestResources"."ConcessionsTable"."Company",
                                                                 "ForestResources"."ConcessionsTable"."Approved",
                                                                 "ForestResources"."ConcessionsTable"."CreatedAt",
                                                                 "ForestResources"."ConcessionsTable"."UpdatedAt",
                                                                 "ForestResources"."ConcessionsTable"."DeletedAt";


DROP VIEW "ForestResources"."ConstituentPermits";

CREATE VIEW "ForestResources"."ConstituentPermits"
as
SELECT cpt."Id",
    cpt."User",
    acc.email AS "Email",
    cpt."PermitType",
    cpt."PermitNumber",
    cpt."Geometry",
    cpt."Approved",
    cpt."CreatedAt",
    cpt."UpdatedAt",
    cpt."DeletedAt"
   FROM "ForestResources"."ConstituentPermitsTable" cpt,
    admin.accounts acc
  WHERE cpt."User" = acc.id;


CREATE RULE "ConstituentPermits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ConstituentPermits" DO INSTEAD  INSERT INTO "ForestResources"."ConstituentPermitsTable" ("Id", "User", "PermitType", "PermitNumber", "Geometry", "Approved", "CreatedAt")
  VALUES (nextval('"ForestResources"."SEQ_ConstituentPermits"'::regclass), new."User", new."PermitType", new."PermitNumber", new."Geometry", new."Approved", new."CreatedAt")
  RETURNING "ForestResources"."ConstituentPermitsTable"."Id",
                                                                        "ForestResources"."ConstituentPermitsTable"."User",
    ( SELECT acc.email
           FROM admin.accounts acc
          WHERE ("ForestResources"."ConstituentPermitsTable"."User" = acc.id)) AS email,
                                                                        "ForestResources"."ConstituentPermitsTable"."PermitType",
                                                                        "ForestResources"."ConstituentPermitsTable"."PermitNumber",
                                                                        "ForestResources"."ConstituentPermitsTable"."Geometry",
                                                                        "ForestResources"."ConstituentPermitsTable"."Approved",
                                                                        "ForestResources"."ConstituentPermitsTable"."CreatedAt",
                                                                        "ForestResources"."ConstituentPermitsTable"."UpdatedAt",
                                                                        "ForestResources"."ConstituentPermitsTable"."DeletedAt";

CREATE RULE "ConstituentPermits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ConstituentPermits" DO INSTEAD  UPDATE "ForestResources"."ConstituentPermitsTable" SET "User" = new."User", "PermitType" = new."PermitType", "PermitNumber" = new."PermitNumber", "Geometry" = new."Geometry", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."ConstituentPermitsTable"."Id" = old."Id")
  RETURNING "ForestResources"."ConstituentPermitsTable"."Id",
                                                                        "ForestResources"."ConstituentPermitsTable"."User",
    ( SELECT acc.email
           FROM admin.accounts acc
          WHERE ("ForestResources"."ConstituentPermitsTable"."User" = acc.id)) AS email,
                                                                        "ForestResources"."ConstituentPermitsTable"."PermitType",
                                                                        "ForestResources"."ConstituentPermitsTable"."PermitNumber",
                                                                        "ForestResources"."ConstituentPermitsTable"."Geometry",
                                                                        "ForestResources"."ConstituentPermitsTable"."Approved",
                                                                        "ForestResources"."ConstituentPermitsTable"."CreatedAt",
                                                                        "ForestResources"."ConstituentPermitsTable"."UpdatedAt",
                                                                        "ForestResources"."ConstituentPermitsTable"."DeletedAt";


DROP VIEW "ForestResources"."DevelopmentPlans";

CREATE VIEW "ForestResources"."DevelopmentPlans"
as
SELECT dpt."Id",
    dpt."DevelopmentUnit",
    dpt."Species",
    dpt."MinimumExploitableDiameter",
    dpt."VolumeTariff",
    dpt."Increment",
    dpt."Approved",
    dpt."CreatedAt",
    dpt."UpdatedAt",
    dpt."DeletedAt"
   FROM "ForestResources"."DevelopmentPlansTable" dpt;


CREATE RULE "DevelopmentPlans_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentPlans" DO INSTEAD  INSERT INTO "ForestResources"."DevelopmentPlansTable" ("Id", "DevelopmentUnit", "Species", "MinimumExploitableDiameter", "VolumeTariff", "Increment", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_DevelopmentPlans"'::regclass), new."DevelopmentUnit", new."Species", new."MinimumExploitableDiameter", new."VolumeTariff", new."Increment", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."DevelopmentPlansTable"."Id",
                                                                      "ForestResources"."DevelopmentPlansTable"."DevelopmentUnit",
                                                                      "ForestResources"."DevelopmentPlansTable"."Species",
                                                                      "ForestResources"."DevelopmentPlansTable"."MinimumExploitableDiameter",
                                                                      "ForestResources"."DevelopmentPlansTable"."VolumeTariff",
                                                                      "ForestResources"."DevelopmentPlansTable"."Increment",
                                                                      "ForestResources"."DevelopmentPlansTable"."Approved",
                                                                      "ForestResources"."DevelopmentPlansTable"."CreatedAt",
                                                                      "ForestResources"."DevelopmentPlansTable"."UpdatedAt",
                                                                      "ForestResources"."DevelopmentPlansTable"."DeletedAt";

CREATE RULE "DevelopmentPlans_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentPlans" DO INSTEAD  UPDATE "ForestResources"."DevelopmentPlansTable" SET "DevelopmentUnit" = new."DevelopmentUnit", "Species" = new."Species", "MinimumExploitableDiameter" = new."MinimumExploitableDiameter", "VolumeTariff" = new."VolumeTariff", "Increment" = new."Increment", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."DevelopmentPlansTable"."Id" = old."Id")
  RETURNING "ForestResources"."DevelopmentPlansTable"."Id",
                                                                      "ForestResources"."DevelopmentPlansTable"."DevelopmentUnit",
                                                                      "ForestResources"."DevelopmentPlansTable"."Species",
                                                                      "ForestResources"."DevelopmentPlansTable"."MinimumExploitableDiameter",
                                                                      "ForestResources"."DevelopmentPlansTable"."VolumeTariff",
                                                                      "ForestResources"."DevelopmentPlansTable"."Increment",
                                                                      "ForestResources"."DevelopmentPlansTable"."Approved",
                                                                      "ForestResources"."DevelopmentPlansTable"."CreatedAt",
                                                                      "ForestResources"."DevelopmentPlansTable"."UpdatedAt",
                                                                      "ForestResources"."DevelopmentPlansTable"."DeletedAt";


CREATE RULE "DevelopmentPlans_instead_of_delete" AS
    ON DELETE TO "ForestResources"."DevelopmentPlans" DO INSTEAD  DELETE FROM "ForestResources"."DevelopmentPlansTable"
  WHERE ("ForestResources"."DevelopmentPlansTable"."Id" = old."Id");


DROP VIEW "ForestResources"."DevelopmentUnits";

CREATE VIEW "ForestResources"."DevelopmentUnits"
as
SELECT ct."Id",
    ct."Name",
    ct."Concession",
    ct."Start",
    ct."End",
    ct."Geometry",
    ct."Approved",
    ct."CreatedAt",
    ct."UpdatedAt",
    ct."DeletedAt"
   FROM "ForestResources"."DevelopmentUnitsTable" ct;


CREATE RULE "DevelopmentUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentUnits" DO INSTEAD  INSERT INTO "ForestResources"."DevelopmentUnitsTable" ("Id", "ResourceType", "Name", "Concession", "Start", "End", "Geometry", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass), ( SELECT rt."Id"
           FROM "ForestResources"."ResourceTypes" rt
          WHERE (rt."Name" = 'Development Unit'::text)
         LIMIT 1), new."Name", new."Concession", new."Start", new."End", new."Geometry", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."DevelopmentUnitsTable"."Id",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Name",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Concession",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Start",
                                                                      "ForestResources"."DevelopmentUnitsTable"."End",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Geometry",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Approved",
                                                                      "ForestResources"."DevelopmentUnitsTable"."CreatedAt",
                                                                      "ForestResources"."DevelopmentUnitsTable"."UpdatedAt",
                                                                      "ForestResources"."DevelopmentUnitsTable"."DeletedAt";


CREATE RULE "DevelopmentUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentUnits" DO INSTEAD  UPDATE "ForestResources"."DevelopmentUnitsTable" SET "Name" = new."Name", "Concession" = new."Concession", "Start" = new."Start", "End" = new."End", "Geometry" = new."Geometry", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."DevelopmentUnitsTable"."Id" = old."Id")
  RETURNING "ForestResources"."DevelopmentUnitsTable"."Id",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Name",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Concession",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Start",
                                                                      "ForestResources"."DevelopmentUnitsTable"."End",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Geometry",
                                                                      "ForestResources"."DevelopmentUnitsTable"."Approved",
                                                                      "ForestResources"."DevelopmentUnitsTable"."CreatedAt",
                                                                      "ForestResources"."DevelopmentUnitsTable"."UpdatedAt",
                                                                      "ForestResources"."DevelopmentUnitsTable"."DeletedAt";


DROP VIEW "ForestResources"."ManagementPlans";

CREATE VIEW "ForestResources"."ManagementPlans"
as
SELECT mpt."Id",
    mpt."ManagementUnit",
    mpt."Species",
    mpt."GrossVolumeUFG",
    mpt."GrossVolumeYear",
    mpt."YieldVolumeYear",
    mpt."CommercialVolumeYear",
    mpt."Approved",
    mpt."CreatedAt",
    mpt."UpdatedAt",
    mpt."DeletedAt"
   FROM "ForestResources"."ManagementPlansTable" mpt;

CREATE RULE "ManagementPlans_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementPlans" DO INSTEAD  INSERT INTO "ForestResources"."ManagementPlansTable" ("Id", "ManagementUnit", "Species", "GrossVolumeUFG", "GrossVolumeYear", "YieldVolumeYear", "CommercialVolumeYear", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_ManagementPlans"'::regclass), new."ManagementUnit", new."Species", new."GrossVolumeUFG", new."GrossVolumeYear", new."YieldVolumeYear", new."CommercialVolumeYear", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."ManagementPlansTable"."Id",
                                                                     "ForestResources"."ManagementPlansTable"."ManagementUnit",
                                                                     "ForestResources"."ManagementPlansTable"."Species",
                                                                     "ForestResources"."ManagementPlansTable"."GrossVolumeUFG",
                                                                     "ForestResources"."ManagementPlansTable"."GrossVolumeYear",
                                                                     "ForestResources"."ManagementPlansTable"."YieldVolumeYear",
                                                                     "ForestResources"."ManagementPlansTable"."CommercialVolumeYear",
                                                                     "ForestResources"."ManagementPlansTable"."Approved",
                                                                     "ForestResources"."ManagementPlansTable"."CreatedAt",
                                                                     "ForestResources"."ManagementPlansTable"."UpdatedAt",
                                                                     "ForestResources"."ManagementPlansTable"."DeletedAt";

CREATE RULE "ManagementPlans_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ManagementPlans" DO INSTEAD  UPDATE "ForestResources"."ManagementPlansTable" SET "ManagementUnit" = new."ManagementUnit", "Species" = new."Species", "GrossVolumeUFG" = new."GrossVolumeUFG", "GrossVolumeYear" = new."GrossVolumeYear", "YieldVolumeYear" = new."YieldVolumeYear", "CommercialVolumeYear" = new."CommercialVolumeYear", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."ManagementPlansTable"."Id" = old."Id")
  RETURNING "ForestResources"."ManagementPlansTable"."Id",
                                                                     "ForestResources"."ManagementPlansTable"."ManagementUnit",
                                                                     "ForestResources"."ManagementPlansTable"."Species",
                                                                     "ForestResources"."ManagementPlansTable"."GrossVolumeUFG",
                                                                     "ForestResources"."ManagementPlansTable"."GrossVolumeYear",
                                                                     "ForestResources"."ManagementPlansTable"."YieldVolumeYear",
                                                                     "ForestResources"."ManagementPlansTable"."CommercialVolumeYear",
                                                                     "ForestResources"."ManagementPlansTable"."Approved",
                                                                     "ForestResources"."ManagementPlansTable"."CreatedAt",
                                                                     "ForestResources"."ManagementPlansTable"."UpdatedAt",
                                                                     "ForestResources"."ManagementPlansTable"."DeletedAt";

CREATE RULE "ManagementPlans_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ManagementPlans" DO INSTEAD  DELETE FROM "ForestResources"."ManagementPlansTable"
  WHERE ("ForestResources"."ManagementPlansTable"."Id" = old."Id");


DROP VIEW "ForestResources"."ManagementUnits";

CREATE VIEW "ForestResources"."ManagementUnits"
as
 SELECT mut."Id",
    mut."Name",
    mut."DevelopmentUnit",
    mut."Geometry",
    mut."Approved",
    mut."CreatedAt",
    mut."UpdatedAt",
    mut."DeletedAt"
   FROM "ForestResources"."ManagementUnitsTable" mut;

CREATE RULE "ManagementUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementUnits" DO INSTEAD  INSERT INTO "ForestResources"."ManagementUnitsTable" ("Id", "ResourceType", "Name", "DevelopmentUnit", "Geometry", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass), ( SELECT rt."Id"
           FROM "ForestResources"."ResourceTypes" rt
          WHERE (rt."Name" = 'Management Unit'::text)
         LIMIT 1), new."Name", new."DevelopmentUnit", new."Geometry", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."ManagementUnitsTable"."Id",
                                                                     "ForestResources"."ManagementUnitsTable"."Name",
                                                                     "ForestResources"."ManagementUnitsTable"."DevelopmentUnit",
                                                                     "ForestResources"."ManagementUnitsTable"."Geometry",
                                                                     "ForestResources"."ManagementUnitsTable"."Approved",
                                                                     "ForestResources"."ManagementUnitsTable"."CreatedAt",
                                                                     "ForestResources"."ManagementUnitsTable"."UpdatedAt",
                                                                     "ForestResources"."ManagementUnitsTable"."DeletedAt";

CREATE RULE "ManagementUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ManagementUnits" DO INSTEAD  UPDATE "ForestResources"."ManagementUnitsTable" SET "Name" = new."Name", "DevelopmentUnit" = new."DevelopmentUnit", "Geometry" = new."Geometry", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."ManagementUnitsTable"."Id" = old."Id")
  RETURNING "ForestResources"."ManagementUnitsTable"."Id",
                                                                     "ForestResources"."ManagementUnitsTable"."Name",
                                                                     "ForestResources"."ManagementUnitsTable"."DevelopmentUnit",
                                                                     "ForestResources"."ManagementUnitsTable"."Geometry",
                                                                     "ForestResources"."ManagementUnitsTable"."Approved",
                                                                     "ForestResources"."ManagementUnitsTable"."CreatedAt",
                                                                     "ForestResources"."ManagementUnitsTable"."UpdatedAt",
                                                                     "ForestResources"."ManagementUnitsTable"."DeletedAt";


DROP VIEW "ForestResources"."Parcels";

CREATE VIEW "ForestResources"."Parcels"
as
SELECT pt."Id",
    pt."Name",
    pt."Geometry",
    pt."Approved",
    pt."CreatedAt",
    pt."UpdatedAt",
    pt."DeletedAt"
   FROM "ForestResources"."ParcelsTable" pt;

CREATE RULE "Parcels_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Parcels" DO INSTEAD  INSERT INTO "ForestResources"."ParcelsTable" ("Id", "ResourceType", "Name", "Geometry", "Approved", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass), ( SELECT rt."Id"
           FROM "ForestResources"."ResourceTypes" rt
          WHERE (rt."Name" = 'Parcel'::text)
         LIMIT 1), new."Name", new."Geometry", new."Approved", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."ParcelsTable"."Id",
                                                             "ForestResources"."ParcelsTable"."Name",
                                                             "ForestResources"."ParcelsTable"."Geometry",
                                                             "ForestResources"."ParcelsTable"."Approved",
                                                             "ForestResources"."ParcelsTable"."CreatedAt",
                                                             "ForestResources"."ParcelsTable"."UpdatedAt",
                                                             "ForestResources"."ParcelsTable"."DeletedAt";


CREATE RULE "Parcels_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Parcels" DO INSTEAD  UPDATE "ForestResources"."ParcelsTable" SET "Name" = new."Name", "Geometry" = new."Geometry", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."ParcelsTable"."Id" = old."Id")
  RETURNING "ForestResources"."ParcelsTable"."Id",
                                                             "ForestResources"."ParcelsTable"."Name",
                                                             "ForestResources"."ParcelsTable"."Geometry",
                                                             "ForestResources"."ParcelsTable"."Approved",
                                                             "ForestResources"."ParcelsTable"."CreatedAt",
                                                             "ForestResources"."ParcelsTable"."UpdatedAt",
                                                             "ForestResources"."ParcelsTable"."DeletedAt";


DROP VIEW "ForestResources"."Logbooks";

CREATE VIEW "ForestResources"."Logbooks"
as
SELECT lb."Id",
       lb."Concession",
       lb."DevelopmentUnit",
       lb."ManagementUnit",
       lb."AnnualAllowableCut",
       lb."ObserveAt",
       lb."Approved",
       lb."CreatedAt",
       lb."UpdatedAt",
       lb."DeletedAt"
FROM "ForestResources"."LogbooksTable" lb;

CREATE RULE "Logbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Logbooks" DO INSTEAD  INSERT INTO "ForestResources"."LogbooksTable" ("Id", "Concession", "DevelopmentUnit", "ManagementUnit", "AnnualAllowableCut", "ObserveAt", "Approved", "CreatedAt", "UpdatedAt")
                                                          VALUES (nextval('"ForestResources"."SEQ_LogbooksTable"'::regclass), new."Concession", new."DevelopmentUnit", new."ManagementUnit", new."AnnualAllowableCut", new."ObserveAt", new."Approved", new."CreatedAt", new."UpdatedAt")
                                                          RETURNING "ForestResources"."LogbooksTable"."Id",
                                                              "ForestResources"."LogbooksTable"."Concession",
                                                              "ForestResources"."LogbooksTable"."DevelopmentUnit",
                                                              "ForestResources"."LogbooksTable"."ManagementUnit",
                                                              "ForestResources"."LogbooksTable"."AnnualAllowableCut",
                                                              "ForestResources"."LogbooksTable"."ObserveAt",
                                                              "ForestResources"."LogbooksTable"."Approved",
                                                              "ForestResources"."LogbooksTable"."CreatedAt",
                                                              "ForestResources"."LogbooksTable"."UpdatedAt",
                                                              "ForestResources"."LogbooksTable"."DeletedAt";

CREATE RULE "Logbooks_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Logbooks" DO INSTEAD  UPDATE "ForestResources"."LogbooksTable" SET "Concession" = new."Concession", "DevelopmentUnit" = new."DevelopmentUnit", "ManagementUnit" = new."ManagementUnit", "AnnualAllowableCut" = new."AnnualAllowableCut", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                          WHERE (old."Id" = new."Id")
                                                          RETURNING "ForestResources"."LogbooksTable"."Id",
                                                              "ForestResources"."LogbooksTable"."Concession",
                                                              "ForestResources"."LogbooksTable"."DevelopmentUnit",
                                                              "ForestResources"."LogbooksTable"."ManagementUnit",
                                                              "ForestResources"."LogbooksTable"."AnnualAllowableCut",
                                                              "ForestResources"."LogbooksTable"."ObserveAt",
                                                              "ForestResources"."LogbooksTable"."Approved",
                                                              "ForestResources"."LogbooksTable"."CreatedAt",
                                                              "ForestResources"."LogbooksTable"."UpdatedAt",
                                                              "ForestResources"."LogbooksTable"."DeletedAt";

CREATE RULE "Logbooks_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Logbooks" DO INSTEAD  DELETE FROM "ForestResources"."LogbooksTable"
                                                          WHERE ("ForestResources"."LogbooksTable"."Id" = old."Id");


DROP VIEW "ForestResources"."SiteLogbooks";

CREATE VIEW "ForestResources"."SiteLogbooks"
as
SELECT slb."Id",
       slb."AnnualAllowableCut",
       slb."ManagementUnit",
       slb."DevelopmentUnit",
       slb."Concession",
       slb."Company",
       slb."Hammer",
       slb."Localization",
       slb."ReportNo",
       slb."ReportNote",
       slb."ObserveAt",
       slb."Approved",
       slb."CreatedAt",
       slb."UpdatedAt",
       slb."DeletedAt"
FROM "ForestResources"."SiteLogbooksTable" slb;

CREATE RULE "SiteLogbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbooks" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbooksTable" ("Id", "AnnualAllowableCut", "ManagementUnit", "DevelopmentUnit", "Concession", "Company", "Hammer", "Localization", "ReportNo", "ReportNote", "ObserveAt", "Approved", "CreatedAt", "UpdatedAt")
                                                              VALUES (nextval('"ForestResources"."SEQ_SiteLogbooksTable"'::regclass), new."AnnualAllowableCut", new."ManagementUnit", new."DevelopmentUnit", new."Concession", new."Company", new."Hammer", new."Localization", new."ReportNo", new."ReportNote", new."ObserveAt", new."Approved", new."CreatedAt", new."UpdatedAt")
                                                              RETURNING "ForestResources"."SiteLogbooksTable"."Id",
                                                                  "ForestResources"."SiteLogbooksTable"."AnnualAllowableCut",
                                                                  "ForestResources"."SiteLogbooksTable"."ManagementUnit",
                                                                  "ForestResources"."SiteLogbooksTable"."DevelopmentUnit",
                                                                  "ForestResources"."SiteLogbooksTable"."Concession",
                                                                  "ForestResources"."SiteLogbooksTable"."Company",
                                                                  "ForestResources"."SiteLogbooksTable"."Hammer",
                                                                  "ForestResources"."SiteLogbooksTable"."Localization",
                                                                  "ForestResources"."SiteLogbooksTable"."ReportNo",
                                                                  "ForestResources"."SiteLogbooksTable"."ReportNote",
                                                                  "ForestResources"."SiteLogbooksTable"."ObserveAt",
                                                                  "ForestResources"."SiteLogbooksTable"."Approved",
                                                                  "ForestResources"."SiteLogbooksTable"."CreatedAt",
                                                                  "ForestResources"."SiteLogbooksTable"."UpdatedAt",
                                                                  "ForestResources"."SiteLogbooksTable"."DeletedAt";

CREATE RULE "SiteLogbooks_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbooks" DO INSTEAD  UPDATE "ForestResources"."SiteLogbooksTable" SET "AnnualAllowableCut" = new."AnnualAllowableCut", "ManagementUnit" = new."ManagementUnit", "DevelopmentUnit" = new."DevelopmentUnit", "Concession" = new."Concession", "Company" = new."Company", "Hammer" = new."Hammer", "Localization" = new."Localization", "ReportNo" = new."ReportNo", "ReportNote" = new."ReportNote", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "CreatedAt" = new."CreatedAt", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                              WHERE (old."Id" = new."Id")
                                                              RETURNING "ForestResources"."SiteLogbooksTable"."Id",
                                                                  "ForestResources"."SiteLogbooksTable"."AnnualAllowableCut",
                                                                  "ForestResources"."SiteLogbooksTable"."ManagementUnit",
                                                                  "ForestResources"."SiteLogbooksTable"."DevelopmentUnit",
                                                                  "ForestResources"."SiteLogbooksTable"."Concession",
                                                                  "ForestResources"."SiteLogbooksTable"."Company",
                                                                  "ForestResources"."SiteLogbooksTable"."Hammer",
                                                                  "ForestResources"."SiteLogbooksTable"."Localization",
                                                                  "ForestResources"."SiteLogbooksTable"."ReportNo",
                                                                  "ForestResources"."SiteLogbooksTable"."ReportNote",
                                                                  "ForestResources"."SiteLogbooksTable"."ObserveAt",
                                                                  "ForestResources"."SiteLogbooksTable"."Approved",
                                                                  "ForestResources"."SiteLogbooksTable"."CreatedAt",
                                                                  "ForestResources"."SiteLogbooksTable"."UpdatedAt",
                                                                  "ForestResources"."SiteLogbooksTable"."DeletedAt";

CREATE RULE "SiteLogbooks_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbooks" DO INSTEAD  DELETE FROM "ForestResources"."SiteLogbooksTable"
                                                              WHERE ("ForestResources"."SiteLogbooksTable"."Id" = old."Id");


DROP VIEW "ForestResources"."LogbookItems";

CREATE VIEW "ForestResources"."LogbookItems"
as
SELECT lbi."Id",
       lbi."Logbook",
       lbi."AnnualAllowableCutInventory",
       lbi."HewingId",
       lbi."Species",
       lbi."MaxDiameter",
       lbi."MinDiameter",
       lbi."Length",
       lbi."Volume",
       lbi."Latitude",
       lbi."Longitude",
       lbi."GPSAccuracy",
       lbi."Note",
       lbi."ObserveAt",
       lbi."Approved",
       lbi."CreatedAt",
       lbi."UpdatedAt",
       lbi."DeletedAt"
FROM "ForestResources"."LogbookItemsTable" lbi;

CREATE RULE "LogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."LogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."LogbookItemsTable" ("Id", "Logbook", "AnnualAllowableCutInventory", "HewingId", "Species", "MaxDiameter", "MinDiameter", "Length", "Volume", "Latitude", "Longitude", "GPSAccuracy", "Note", "ObserveAt", "Approved", "CreatedAt", "UpdatedAt", "DeletedAt")
                                                              VALUES (nextval('"ForestResources"."SEQ_LogbookItemsTable"'::regclass), new."Logbook", new."AnnualAllowableCutInventory", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."Length", new."Volume", new."Latitude", new."Longitude", new."GPSAccuracy", new."Note", new."ObserveAt", new."Approved", new."CreatedAt", new."UpdatedAt", new."DeletedAt")
                                                              RETURNING "ForestResources"."LogbookItemsTable"."Id",
                                                                  "ForestResources"."LogbookItemsTable"."Logbook",
                                                                  "ForestResources"."LogbookItemsTable"."AnnualAllowableCutInventory",
                                                                  "ForestResources"."LogbookItemsTable"."HewingId",
                                                                  "ForestResources"."LogbookItemsTable"."Species",
                                                                  "ForestResources"."LogbookItemsTable"."MaxDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."MinDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."Length",
                                                                  "ForestResources"."LogbookItemsTable"."Volume",
                                                                  "ForestResources"."LogbookItemsTable"."Latitude",
                                                                  "ForestResources"."LogbookItemsTable"."Longitude",
                                                                  "ForestResources"."LogbookItemsTable"."GPSAccuracy",
                                                                  "ForestResources"."LogbookItemsTable"."Note",
                                                                  "ForestResources"."LogbookItemsTable"."ObserveAt",
                                                                  "ForestResources"."LogbookItemsTable"."Approved",
                                                                  "ForestResources"."LogbookItemsTable"."CreatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."UpdatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."DeletedAt";

CREATE RULE "LogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."LogbookItems" DO INSTEAD  UPDATE "ForestResources"."LogbookItemsTable" SET "AnnualAllowableCutInventory" = new."AnnualAllowableCutInventory", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "Length" = new."Length", "Volume" = new."Volume", "Latitude" = new."Latitude", "Longitude" = new."Longitude", "GPSAccuracy" = new."GPSAccuracy", "Note" = new."Note", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                              WHERE (old."Id" = new."Id")
                                                              RETURNING "ForestResources"."LogbookItemsTable"."Id",
                                                                  "ForestResources"."LogbookItemsTable"."Logbook",
                                                                  "ForestResources"."LogbookItemsTable"."AnnualAllowableCutInventory",
                                                                  "ForestResources"."LogbookItemsTable"."HewingId",
                                                                  "ForestResources"."LogbookItemsTable"."Species",
                                                                  "ForestResources"."LogbookItemsTable"."MaxDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."MinDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."Length",
                                                                  "ForestResources"."LogbookItemsTable"."Volume",
                                                                  "ForestResources"."LogbookItemsTable"."Latitude",
                                                                  "ForestResources"."LogbookItemsTable"."Longitude",
                                                                  "ForestResources"."LogbookItemsTable"."GPSAccuracy",
                                                                  "ForestResources"."LogbookItemsTable"."Note",
                                                                  "ForestResources"."LogbookItemsTable"."ObserveAt",
                                                                  "ForestResources"."LogbookItemsTable"."Approved",
                                                                  "ForestResources"."LogbookItemsTable"."CreatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."UpdatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."DeletedAt";

CREATE RULE "LogbookItems_instead_of_delete" AS
    ON DELETE TO "ForestResources"."LogbookItems" DO INSTEAD  DELETE FROM "ForestResources"."LogbookItemsTable"
                                                              WHERE ("ForestResources"."LogbookItemsTable"."Id" = old."Id");


DROP VIEW "ForestResources"."SiteLogbookItems";

CREATE VIEW "ForestResources"."SiteLogbookItems"
as
SELECT slbi."Id",
       slbi."SiteLogbook",
       slbi."HewingId",
       slbi."Date",
       slbi."MaxDiameter",
       slbi."MinDiameter",
       slbi."AverageDiameter",
       slbi."Length",
       slbi."Volume",
       slbi."ObserveAt",
       slbi."Approved",
       slbi."CreatedAt",
       slbi."UpdatedAt",
       slbi."DeletedAt"
FROM "ForestResources"."SiteLogbookItemsTable" slbi;

CREATE RULE "SiteLogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookItemsTable" ("Id", "SiteLogbook", "HewingId", "Date", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "ObserveAt", "Approved", "CreatedAt", "UpdatedAt")
                                                                  VALUES (nextval('"ForestResources"."SEQ_SiteLogbookItemsTable"'::regclass), new."SiteLogbook", new."HewingId", new."Date", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."ObserveAt", new."Approved", new."CreatedAt", new."UpdatedAt")
                                                                  RETURNING "ForestResources"."SiteLogbookItemsTable"."Id",
                                                                      "ForestResources"."SiteLogbookItemsTable"."SiteLogbook",
                                                                      "ForestResources"."SiteLogbookItemsTable"."HewingId",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Date",
                                                                      "ForestResources"."SiteLogbookItemsTable"."MaxDiameter",
                                                                      "ForestResources"."SiteLogbookItemsTable"."MinDiameter",
                                                                      "ForestResources"."SiteLogbookItemsTable"."AverageDiameter",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Length",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Volume",
                                                                      "ForestResources"."SiteLogbookItemsTable"."ObserveAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Approved",
                                                                      "ForestResources"."SiteLogbookItemsTable"."CreatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."UpdatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."DeletedAt";

CREATE RULE "SiteLogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookItems" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookItemsTable" SET "HewingId" = new."HewingId", "Date" = new."Date", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                                  WHERE (old."Id" = new."Id")
                                                                  RETURNING "ForestResources"."SiteLogbookItemsTable"."Id",
                                                                      "ForestResources"."SiteLogbookItemsTable"."SiteLogbook",
                                                                      "ForestResources"."SiteLogbookItemsTable"."HewingId",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Date",
                                                                      "ForestResources"."SiteLogbookItemsTable"."MaxDiameter",
                                                                      "ForestResources"."SiteLogbookItemsTable"."MinDiameter",
                                                                      "ForestResources"."SiteLogbookItemsTable"."AverageDiameter",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Length",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Volume",
                                                                      "ForestResources"."SiteLogbookItemsTable"."ObserveAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Approved",
                                                                      "ForestResources"."SiteLogbookItemsTable"."CreatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."UpdatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."DeletedAt";


CREATE RULE "SiteLogbookItems_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookItems" DO INSTEAD  DELETE FROM "ForestResources"."SiteLogbookItemsTable"
                                                                  WHERE ("ForestResources"."SiteLogbookItemsTable"."Id" = old."Id");


DROP VIEW "ForestResources"."SiteLogbookLogs";

CREATE VIEW "ForestResources"."SiteLogbookLogs"
as
SELECT slbl."Id",
       slbl."SiteLogbookItem",
       slbl."HewingId",
       slbl."Species",
       slbl."MaxDiameter",
       slbl."MinDiameter",
       slbl."AverageDiameter",
       slbl."Length",
       slbl."Volume",
       slbl."Note",
       slbl."EvacuationDate",
       slbl."Lat",
       slbl."Lon",
       slbl."GPSAccuracy",
       slbl."ObserveAt",
       slbl."Approved",
       slbl."CreatedAt",
       slbl."UpdatedAt",
       slbl."DeletedAt"
FROM "ForestResources"."SiteLogbookLogsTable" slbl;


CREATE RULE "SiteLogbookLogs_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookLogsTable" ("Id", "SiteLogbookItem", "HewingId", "Species", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "Note", "EvacuationDate", "Lat", "Lon", "GPSAccuracy", "ObserveAt", "Approved", "CreatedAt", "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_SiteLogbookLogsTable"'::regclass), new."SiteLogbookItem", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."Note", new."EvacuationDate", new."Lat", new."Lon", new."GPSAccuracy", new."ObserveAt", new."Approved", new."CreatedAt", new."UpdatedAt")
                                                                 RETURNING "ForestResources"."SiteLogbookLogsTable"."Id",
                                                                     "ForestResources"."SiteLogbookLogsTable"."SiteLogbookItem",
                                                                     "ForestResources"."SiteLogbookLogsTable"."HewingId",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Species",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MaxDiameter",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MinDiameter",
                                                                     "ForestResources"."SiteLogbookLogsTable"."AverageDiameter",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Length",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Volume",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Note",
                                                                     "ForestResources"."SiteLogbookLogsTable"."EvacuationDate",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Lat",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Lon",
                                                                     "ForestResources"."SiteLogbookLogsTable"."GPSAccuracy",
                                                                     "ForestResources"."SiteLogbookLogsTable"."ObserveAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Approved",
                                                                     "ForestResources"."SiteLogbookLogsTable"."CreatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."UpdatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."DeletedAt";

CREATE RULE "SiteLogbookLogs_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookLogsTable" SET "SiteLogbookItem" = new."SiteLogbookItem", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "Note" = new."Note", "EvacuationDate" = new."EvacuationDate", "Lat" = new."Lat", "Lon" = new."Lon", "GPSAccuracy" = new."GPSAccuracy", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                                 WHERE (old."Id" = new."Id")
                                                                 RETURNING "ForestResources"."SiteLogbookLogsTable"."Id",
                                                                     "ForestResources"."SiteLogbookLogsTable"."SiteLogbookItem",
                                                                     "ForestResources"."SiteLogbookLogsTable"."HewingId",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Species",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MaxDiameter",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MinDiameter",
                                                                     "ForestResources"."SiteLogbookLogsTable"."AverageDiameter",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Length",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Volume",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Note",
                                                                     "ForestResources"."SiteLogbookLogsTable"."EvacuationDate",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Lat",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Lon",
                                                                     "ForestResources"."SiteLogbookLogsTable"."GPSAccuracy",
                                                                     "ForestResources"."SiteLogbookLogsTable"."ObserveAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Approved",
                                                                     "ForestResources"."SiteLogbookLogsTable"."CreatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."UpdatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."DeletedAt";

CREATE RULE "SiteLogbookLogs_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  DELETE FROM "ForestResources"."SiteLogbookLogsTable"
                                                                 WHERE ("ForestResources"."SiteLogbookLogsTable"."Id" = old."Id");
