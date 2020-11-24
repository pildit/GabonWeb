ALTER TABLE "ForestResources"."LogbooksTable"
    ADD COLUMN IF NOT EXISTS   "MobileId" varchar DEFAULT NULL;

ALTER TABLE "ForestResources"."LogbookItemsTable"
    ADD COLUMN IF NOT EXISTS   "MobileId" varchar DEFAULT NULL;

ALTER TABLE "ForestResources"."SiteLogbooksTable"
    ADD COLUMN IF NOT EXISTS   "MobileId" varchar DEFAULT NULL;

ALTER TABLE "ForestResources"."SiteLogbookItemsTable"
    ADD COLUMN IF NOT EXISTS   "MobileId" varchar DEFAULT NULL;

ALTER TABLE "ForestResources"."SiteLogbookLogsTable"
    ADD COLUMN IF NOT EXISTS   "MobileId" varchar DEFAULT NULL;

ALTER TABLE "ForestResources"."AnnualAllowableCutInventoryTable"
    ADD COLUMN IF NOT EXISTS   "MobileId" varchar DEFAULT NULL;


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
       lb."MobileId",
       lb."CreatedAt",
       lb."UpdatedAt",
       lb."DeletedAt"
FROM "ForestResources"."LogbooksTable" lb;

CREATE RULE "Logbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Logbooks" DO INSTEAD  INSERT INTO "ForestResources"."LogbooksTable" ("Id", "Concession", "DevelopmentUnit", "ManagementUnit", "AnnualAllowableCut", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
                                                          VALUES (nextval('"ForestResources"."SEQ_LogbooksTable"'::regclass), new."Concession", new."DevelopmentUnit", new."ManagementUnit", new."AnnualAllowableCut", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
                                                          RETURNING "ForestResources"."LogbooksTable"."Id",
                                                              "ForestResources"."LogbooksTable"."Concession",
                                                              "ForestResources"."LogbooksTable"."DevelopmentUnit",
                                                              "ForestResources"."LogbooksTable"."ManagementUnit",
                                                              "ForestResources"."LogbooksTable"."AnnualAllowableCut",
                                                              "ForestResources"."LogbooksTable"."ObserveAt",
                                                              "ForestResources"."LogbooksTable"."Approved",
                                                              "ForestResources"."LogbooksTable"."MobileId",
                                                              "ForestResources"."LogbooksTable"."CreatedAt",
                                                              "ForestResources"."LogbooksTable"."UpdatedAt",
                                                              "ForestResources"."LogbooksTable"."DeletedAt";

CREATE RULE "Logbooks_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Logbooks" DO INSTEAD  UPDATE "ForestResources"."LogbooksTable" SET "Concession" = new."Concession", "DevelopmentUnit" = new."DevelopmentUnit", "ManagementUnit" = new."ManagementUnit", "AnnualAllowableCut" = new."AnnualAllowableCut", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                          WHERE ("LogbooksTable"."Id" = old."Id")
                                                          RETURNING "ForestResources"."LogbooksTable"."Id",
                                                              "ForestResources"."LogbooksTable"."Concession",
                                                              "ForestResources"."LogbooksTable"."DevelopmentUnit",
                                                              "ForestResources"."LogbooksTable"."ManagementUnit",
                                                              "ForestResources"."LogbooksTable"."AnnualAllowableCut",
                                                              "ForestResources"."LogbooksTable"."ObserveAt",
                                                              "ForestResources"."LogbooksTable"."Approved",
                                                              "ForestResources"."LogbooksTable"."MobileId",
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
       slb."MobileId",
       slb."CreatedAt",
       slb."UpdatedAt",
       slb."DeletedAt"
FROM "ForestResources"."SiteLogbooksTable" slb;

CREATE RULE "SiteLogbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbooks" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbooksTable" ("Id", "AnnualAllowableCut", "ManagementUnit", "DevelopmentUnit", "Concession", "Company", "Hammer", "Localization", "ReportNo", "ReportNote", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
                                                              VALUES (nextval('"ForestResources"."SEQ_SiteLogbooksTable"'::regclass), new."AnnualAllowableCut", new."ManagementUnit", new."DevelopmentUnit", new."Concession", new."Company", new."Hammer", new."Localization", new."ReportNo", new."ReportNote", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."CreatedAt")
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
                                                                  "ForestResources"."SiteLogbooksTable"."MobileId",
                                                                  "ForestResources"."SiteLogbooksTable"."CreatedAt",
                                                                  "ForestResources"."SiteLogbooksTable"."UpdatedAt",
                                                                  "ForestResources"."SiteLogbooksTable"."DeletedAt";

CREATE RULE "SiteLogbooks_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbooks" DO INSTEAD  UPDATE "ForestResources"."SiteLogbooksTable" SET "AnnualAllowableCut" = new."AnnualAllowableCut", "ManagementUnit" = new."ManagementUnit", "DevelopmentUnit" = new."DevelopmentUnit", "Concession" = new."Concession", "Company" = new."Company", "Hammer" = new."Hammer", "Localization" = new."Localization", "ReportNo" = new."ReportNo", "ReportNote" = new."ReportNote", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "CreatedAt" = new."CreatedAt", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                              WHERE ("SiteLogbooksTable"."Id" = old."Id")
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
                                                                  "ForestResources"."SiteLogbooksTable"."MobileId",
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
       lbi."Lat",
       lbi."Lon",
       lbi."GPSAccu",
       lbi."Note",
       lbi."ObserveAt",
       lbi."Approved",
       lbi."MobileId",
       lbi."CreatedAt",
       lbi."UpdatedAt",
       lbi."DeletedAt"
FROM "ForestResources"."LogbookItemsTable" lbi;

CREATE RULE "LogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."LogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."LogbookItemsTable" ("Id", "Logbook", "AnnualAllowableCutInventory", "HewingId", "Species", "MaxDiameter", "MinDiameter", "Length", "Volume", "Lat", "Lon", "GPSAccu", "Note", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
                                                              VALUES (nextval('"ForestResources"."SEQ_LogbookItemsTable"'::regclass), new."Logbook", new."AnnualAllowableCutInventory", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."Length", new."Volume", new."Lat", new."Lon", new."GPSAccu", new."Note", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt", new."DeletedAt")
                                                              RETURNING "ForestResources"."LogbookItemsTable"."Id",
                                                                  "ForestResources"."LogbookItemsTable"."Logbook",
                                                                  "ForestResources"."LogbookItemsTable"."AnnualAllowableCutInventory",
                                                                  "ForestResources"."LogbookItemsTable"."HewingId",
                                                                  "ForestResources"."LogbookItemsTable"."Species",
                                                                  "ForestResources"."LogbookItemsTable"."MaxDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."MinDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."Length",
                                                                  "ForestResources"."LogbookItemsTable"."Volume",
                                                                  "ForestResources"."LogbookItemsTable"."Lat",
                                                                  "ForestResources"."LogbookItemsTable"."Lon",
                                                                  "ForestResources"."LogbookItemsTable"."GPSAccu",
                                                                  "ForestResources"."LogbookItemsTable"."Note",
                                                                  "ForestResources"."LogbookItemsTable"."ObserveAt",
                                                                  "ForestResources"."LogbookItemsTable"."Approved",
                                                                  "ForestResources"."LogbookItemsTable"."MobileId",
                                                                  "ForestResources"."LogbookItemsTable"."CreatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."UpdatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."DeletedAt";

CREATE RULE "LogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."LogbookItems" DO INSTEAD  UPDATE "ForestResources"."LogbookItemsTable" SET "AnnualAllowableCutInventory" = new."AnnualAllowableCutInventory", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "Length" = new."Length", "Volume" = new."Volume", "Lat" = new."Lat", "Lon" = new."Lon", "GPSAccu" = new."GPSAccu", "Note" = new."Note", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                              WHERE ("LogbookItemsTable"."Id" = old."Id")
                                                              RETURNING "ForestResources"."LogbookItemsTable"."Id",
                                                                  "ForestResources"."LogbookItemsTable"."Logbook",
                                                                  "ForestResources"."LogbookItemsTable"."AnnualAllowableCutInventory",
                                                                  "ForestResources"."LogbookItemsTable"."HewingId",
                                                                  "ForestResources"."LogbookItemsTable"."Species",
                                                                  "ForestResources"."LogbookItemsTable"."MaxDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."MinDiameter",
                                                                  "ForestResources"."LogbookItemsTable"."Length",
                                                                  "ForestResources"."LogbookItemsTable"."Volume",
                                                                  "ForestResources"."LogbookItemsTable"."Lat",
                                                                  "ForestResources"."LogbookItemsTable"."Lon",
                                                                  "ForestResources"."LogbookItemsTable"."GPSAccu",
                                                                  "ForestResources"."LogbookItemsTable"."Note",
                                                                  "ForestResources"."LogbookItemsTable"."ObserveAt",
                                                                  "ForestResources"."LogbookItemsTable"."Approved",
                                                                  "ForestResources"."LogbookItemsTable"."MobileId",
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
       slbi."MobileId",
       slbi."CreatedAt",
       slbi."UpdatedAt",
       slbi."DeletedAt"
FROM "ForestResources"."SiteLogbookItemsTable" slbi;

CREATE RULE "SiteLogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookItemsTable" ("Id", "SiteLogbook", "HewingId", "Date", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
                                                                  VALUES (nextval('"ForestResources"."SEQ_SiteLogbookItemsTable"'::regclass), new."SiteLogbook", new."HewingId", new."Date", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
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
                                                                      "ForestResources"."SiteLogbookItemsTable"."MobileId",
                                                                      "ForestResources"."SiteLogbookItemsTable"."CreatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."UpdatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."DeletedAt";

CREATE RULE "SiteLogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookItems" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookItemsTable" SET "HewingId" = new."HewingId", "Date" = new."Date", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                                  WHERE ("SiteLogbookItemsTable"."Id" = old."Id")
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
                                                                      "ForestResources"."SiteLogbookItemsTable"."MobileId",
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
       slbl."GPSAccu",
       slbl."ObserveAt",
       slbl."Approved",
       slbl."MobileId",
       slbl."CreatedAt",
       slbl."UpdatedAt",
       slbl."DeletedAt"
FROM "ForestResources"."SiteLogbookLogsTable" slbl;


CREATE RULE "SiteLogbookLogs_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookLogsTable" ("Id", "SiteLogbookItem", "HewingId", "Species", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "Note", "EvacuationDate", "Lat", "Lon", "GPSAccu", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_SiteLogbookLogsTable"'::regclass), new."SiteLogbookItem", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."Note", new."EvacuationDate", new."Lat", new."Lon", new."GPSAccu", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
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
                                                                     "ForestResources"."SiteLogbookLogsTable"."GPSAccu",
                                                                     "ForestResources"."SiteLogbookLogsTable"."ObserveAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Approved",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MobileId",
                                                                     "ForestResources"."SiteLogbookLogsTable"."CreatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."UpdatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."DeletedAt";

CREATE RULE "SiteLogbookLogs_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookLogsTable" SET "SiteLogbookItem" = new."SiteLogbookItem", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "Note" = new."Note", "EvacuationDate" = new."EvacuationDate", "Lat" = new."Lat", "Lon" = new."Lon", "GPSAccu" = new."GPSAccu", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                                 WHERE ("SiteLogbookLogsTable"."Id" = old."Id")
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
                                                                     "ForestResources"."SiteLogbookLogsTable"."GPSAccu",
                                                                     "ForestResources"."SiteLogbookLogsTable"."ObserveAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Approved",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MobileId",
                                                                     "ForestResources"."SiteLogbookLogsTable"."CreatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."UpdatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."DeletedAt";

CREATE RULE "SiteLogbookLogs_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  DELETE FROM "ForestResources"."SiteLogbookLogsTable"
                                                                 WHERE ("ForestResources"."SiteLogbookLogsTable"."Id" = old."Id");


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
    aacit."MobileId",
    aacit."CreatedAt",
    aacit."UpdatedAt",
    aacit."DeletedAt"
   FROM "ForestResources"."AnnualAllowableCutInventoryTable" aacit;


CREATE RULE "AnnualAllowableCutInventory_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  INSERT INTO "ForestResources"."AnnualAllowableCutInventoryTable" ("Id", "AnnualAllowableCut", "Species", "Quality", "Parcel", "TreeId", "DiameterBreastHeight", "Geometry", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_AnnualAllowableCutInventory"'::regclass), new."AnnualAllowableCut", new."Species", new."Quality", new."Parcel", new."TreeId", new."DiameterBreastHeight", new."Geometry", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."AnnualAllowableCutInventoryTable"."Id",
    "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Species",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Quality",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Parcel",
    "ForestResources"."AnnualAllowableCutInventoryTable"."TreeId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Geometry",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Approved",
    "ForestResources"."AnnualAllowableCutInventoryTable"."MobileId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."CreatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."UpdatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DeletedAt";

CREATE RULE "AnnualAllowableCutInventory_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  UPDATE "ForestResources"."AnnualAllowableCutInventoryTable" SET "AnnualAllowableCut" = new."AnnualAllowableCut", "Species" = new."Species", "Quality" = new."Quality", "Parcel" = new."Parcel", "TreeId" = new."TreeId", "DiameterBreastHeight" = new."DiameterBreastHeight", "Geometry" = new."Geometry", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
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
    "ForestResources"."AnnualAllowableCutInventoryTable"."MobileId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."CreatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."UpdatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DeletedAt";

CREATE RULE "AnnualAllowableCutInventory_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  DELETE FROM"ForestResources". "AnnualAllowableCutInventoryTable"
  WHERE ("ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id");
