DROP VIEW IF EXISTS "ForestResources"."LogbookItems";
DROP VIEW IF EXISTS "ForestResources"."SiteLogbookLogs";
DROP VIEW IF EXISTS "ForestResources"."SiteLogbookItems";

alter table "ForestResources"."LogbookItemsTable" alter column "HewingId" type varchar using "HewingId"::varchar;
alter table "ForestResources"."LogbookItemsTable" drop column if exists "AnnualAllowableCutInventory" cascade;
alter table "ForestResources"."LogbookItemsTable" add if not exists "TreeId" varchar;

alter table "ForestResources"."SiteLogbookItemsTable" alter column "HewingId" type varchar using "HewingId"::varchar;
alter table "ForestResources"."SiteLogbookItemsTable" alter column "HewingId" drop not null;

alter table "ForestResources"."SiteLogbookLogsTable" add if not exists  "LogId" varchar;


CREATE VIEW "ForestResources"."LogbookItems"
as
SELECT lbi."Id",
    lbi."Logbook",
    lbi."TreeId",
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
    ON INSERT TO "ForestResources"."LogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."LogbookItemsTable" ("Id", "Logbook", "TreeId", "HewingId", "Species", "MaxDiameter", "MinDiameter", "Length", "Volume", "Lat", "Lon", "GpsAccu", "Note", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
  VALUES (nextval('"ForestResources"."SEQ_LogbookItemsTable"'::regclass), new."Logbook", new."TreeId", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."Length", new."Volume", new."Lat", new."Lon", new."GpsAccu", new."Note", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt", new."DeletedAt")
  RETURNING "ForestResources"."LogbookItemsTable"."Id",
    "ForestResources"."LogbookItemsTable"."Logbook",
    "ForestResources"."LogbookItemsTable"."TreeId",
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
    ON UPDATE TO "ForestResources"."LogbookItems" DO INSTEAD  UPDATE "ForestResources"."LogbookItemsTable" SET "TreeId" = new."TreeId", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "Length" = new."Length", "Volume" = new."Volume", "Lat" = new."Lat", "Lon" = new."Lon", "GpsAccu" = new."GpsAccu", "Note" = new."Note", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE (old."Id" = new."Id")
  RETURNING "ForestResources"."LogbookItemsTable"."Id",
    "ForestResources"."LogbookItemsTable"."Logbook",
    "ForestResources"."LogbookItemsTable"."TreeId",
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




CREATE VIEW "ForestResources"."SiteLogbookLogs"
as
SELECT slbl."Id",
    slbl."SiteLogbookItem",
    slbl."LogId",
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
    ON INSERT TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookLogsTable" ("Id", "SiteLogbookItem", "LogId", "HewingId", "Species", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "Note", "EvacuationDate", "Lat", "Lon", "GpsAccu", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_SiteLogbookLogsTable"'::regclass), new."SiteLogbookItem", new."LogId", new."HewingId", new."Species", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."Note", new."EvacuationDate", new."Lat", new."Lon", new."GpsAccu", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."SiteLogbookLogsTable"."Id",
    "ForestResources"."SiteLogbookLogsTable"."SiteLogbookItem",
    "ForestResources"."SiteLogbookLogsTable"."LogId",
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
    ON UPDATE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookLogsTable" SET "SiteLogbookItem" = new."SiteLogbookItem", "LogId" = new."LogId", "HewingId" = new."HewingId", "Species" = new."Species", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "Note" = new."Note", "EvacuationDate" = new."EvacuationDate", "Lat" = new."Lat", "Lon" = new."Lon", "GpsAccu" = new."GpsAccu", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE (old."Id" = new."Id")
  RETURNING "ForestResources"."SiteLogbookLogsTable"."Id",
    "ForestResources"."SiteLogbookLogsTable"."SiteLogbookItem",
    "ForestResources"."SiteLogbookLogsTable"."LogId",
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

CREATE RULE "SiteLogbookItems_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookItems" DO INSTEAD  DELETE FROM "ForestResources"."SiteLogbookItemsTable"
                                                                  WHERE ("ForestResources"."SiteLogbookItemsTable"."Id" = old."Id");


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
                                                                      "ForestResources"."SiteLogbookItemsTable"."MobileId",
                                                                      "ForestResources"."SiteLogbookItemsTable"."CreatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."UpdatedAt",
                                                                      "ForestResources"."SiteLogbookItemsTable"."DeletedAt";
