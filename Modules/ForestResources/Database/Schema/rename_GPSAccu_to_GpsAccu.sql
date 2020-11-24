alter table "ForestResources"."LogbookItemsTable" rename column "GPSAccu" to "GpsAccu";
alter table "ForestResources"."SiteLogbookLogsTable" rename column "GPSAccu" to "GpsAccu";

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
    lbi."GpsAccu",
    lbi."Note",
    lbi."ObserveAt",
    lbi."Approved",
    lbi."MobileId",
    lbi."CreatedAt",
    lbi."UpdatedAt",
    lbi."DeletedAt"
   FROM "ForestResources"."LogbookItemsTable" lbi;

CREATE RULE "LogbookItems_instead_of_delete" AS
    ON DELETE TO "ForestResources"."LogbookItems" DO INSTEAD  DELETE FROM "ForestResources"."LogbookItemsTable"
                                                              WHERE ("ForestResources"."LogbookItemsTable"."Id" = old."Id");

CREATE RULE "LogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."LogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."LogbookItemsTable" ("Id", "Logbook", "AnnualAllowableCutInventory", "HewingId", "Species", "MaxDiameter", "MinDiameter", "Length", "Volume", "Lat", "Lon", "GpsAccu", "Note", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
                                                              VALUES (nextval(' "ForestResources"."SEQ_LogbookItemsTable"'::regclass), new."Logbook", new."AnnualAllowableCutInventory", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."Length", new."Volume", new."Lat", new."Lon", new."GpsAccu", new."Note", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt", new."DeletedAt")
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
                                                                  "ForestResources"."LogbookItemsTable"."GpsAccu",
                                                                  "ForestResources"."LogbookItemsTable"."Note",
                                                                  "ForestResources"."LogbookItemsTable"."ObserveAt",
                                                                  "ForestResources"."LogbookItemsTable"."Approved",
                                                                  "ForestResources"."LogbookItemsTable"."MobileId",
                                                                  "ForestResources"."LogbookItemsTable"."CreatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."UpdatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."DeletedAt";

CREATE RULE "LogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."LogbookItems" DO INSTEAD  UPDATE "ForestResources"."LogbookItemsTable" SET "AnnualAllowableCutInventory" = new."AnnualAllowableCutInventory", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "Length" = new."Length", "Volume" = new."Volume", "Lat" = new."Lat", "Lon" = new."Lon", "GpsAccu" = new."GpsAccu", "Note" = new."Note", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
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
                                                                  "ForestResources"."LogbookItemsTable"."GpsAccu",
                                                                  "ForestResources"."LogbookItemsTable"."Note",
                                                                  "ForestResources"."LogbookItemsTable"."ObserveAt",
                                                                  "ForestResources"."LogbookItemsTable"."Approved",
                                                                  "ForestResources"."LogbookItemsTable"."MobileId",
                                                                  "ForestResources"."LogbookItemsTable"."CreatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."UpdatedAt",
                                                                  "ForestResources"."LogbookItemsTable"."DeletedAt";


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
       slbl."GpsAccu",
       slbl."ObserveAt",
       slbl."Approved",
       slbl."MobileId",
       slbl."CreatedAt",
       slbl."UpdatedAt",
       slbl."DeletedAt"
FROM "ForestResources"."SiteLogbookLogsTable" slbl;

CREATE RULE "SiteLogbookLogs_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  DELETE FROM "ForestResources"."SiteLogbookLogsTable"
                                                                 WHERE ("ForestResources"."SiteLogbookLogsTable"."Id" = old."Id");
CREATE RULE "SiteLogbookLogs_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookLogsTable" ("Id", "SiteLogbookItem", "HewingId", "Species", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "Note", "EvacuationDate", "Lat", "Lon", "GpsAccu", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_SiteLogbookLogsTable"'::regclass), new."SiteLogbookItem", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."Note", new."EvacuationDate", new."Lat", new."Lon", new."GpsAccu", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
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
                                                                     "ForestResources"."SiteLogbookLogsTable"."GpsAccu",
                                                                     "ForestResources"."SiteLogbookLogsTable"."ObserveAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Approved",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MobileId",
                                                                     "ForestResources"."SiteLogbookLogsTable"."CreatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."UpdatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."DeletedAt";

CREATE RULE "SiteLogbookLogs_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookLogsTable" SET "SiteLogbookItem" = new."SiteLogbookItem", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "Note" = new."Note", "EvacuationDate" = new."EvacuationDate", "Lat" = new."Lat", "Lon" = new."Lon", "GpsAccu" = new."GpsAccu", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
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
                                                                     "ForestResources"."SiteLogbookLogsTable"."GpsAccu",
                                                                     "ForestResources"."SiteLogbookLogsTable"."ObserveAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."Approved",
                                                                     "ForestResources"."SiteLogbookLogsTable"."MobileId",
                                                                     "ForestResources"."SiteLogbookLogsTable"."CreatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."UpdatedAt",
                                                                     "ForestResources"."SiteLogbookLogsTable"."DeletedAt";
