create or replace view "ForestResources"."SiteLogbookLogs"
            ("Id", "SiteLogbookItem", "LogId", "HewingId", "Species", "MaxDiameter", "MinDiameter", "AverageDiameter",
             "Length", "Volume", "Note", "EvacuationDate", "Lat", "Lon", "GpsAccu", "ObserveAt", "Approved", "MobileId",
             "CreatedAt", "UpdatedAt", "DeletedAt")
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


CREATE OR REPLACE RULE "SiteLogbookLogs_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD DELETE
                                                                FROM "ForestResources"."SiteLogbookLogsTable"
                                                                WHERE "SiteLogbookLogsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "SiteLogbookLogs_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookLogs" DO INSTEAD INSERT INTO "ForestResources"."SiteLogbookLogsTable" ("Id",
                                                                                                                      "SiteLogbookItem",
                                                                                                                      "LogId",
                                                                                                                      "HewingId",
                                                                                                                      "Species",
                                                                                                                      "MaxDiameter",
                                                                                                                      "MinDiameter",
                                                                                                                      "AverageDiameter",
                                                                                                                      "Length",
                                                                                                                      "Volume",
                                                                                                                      "Note",
                                                                                                                      "EvacuationDate",
                                                                                                                      "Lat",
                                                                                                                      "Lon",
                                                                                                                      "GpsAccu",
                                                                                                                      "ObserveAt",
                                                                                                                      "Approved",
                                                                                                                      "MobileId",
                                                                                                                      "CreatedAt",
                                                                                                                      "UpdatedAt")
                                                                VALUES (nextval('"ForestResources"."SEQ_SiteLogbookLogsTable"'::regclass),
                                                                        new."SiteLogbookItem", new."LogId",
                                                                        new."HewingId", new."Species",
                                                                        new."MaxDiameter", new."MinDiameter",
                                                                        new."AverageDiameter", new."Length",
                                                                        new."Volume", new."Note", new."EvacuationDate",
                                                                        new."Lat", new."Lon", new."GpsAccu",
                                                                        new."ObserveAt", new."Approved", new."MobileId",
                                                                        new."CreatedAt", new."UpdatedAt")
                                                                RETURNING "SiteLogbookLogsTable"."Id", "SiteLogbookLogsTable"."SiteLogbookItem", "SiteLogbookLogsTable"."LogId", "SiteLogbookLogsTable"."HewingId", "SiteLogbookLogsTable"."Species", "SiteLogbookLogsTable"."MaxDiameter", "SiteLogbookLogsTable"."MinDiameter", "SiteLogbookLogsTable"."AverageDiameter", "SiteLogbookLogsTable"."Length", "SiteLogbookLogsTable"."Volume", "SiteLogbookLogsTable"."Note", "SiteLogbookLogsTable"."EvacuationDate", "SiteLogbookLogsTable"."Lat", "SiteLogbookLogsTable"."Lon", "SiteLogbookLogsTable"."GpsAccu", "SiteLogbookLogsTable"."ObserveAt", "SiteLogbookLogsTable"."Approved", "SiteLogbookLogsTable"."MobileId", "SiteLogbookLogsTable"."CreatedAt", "SiteLogbookLogsTable"."UpdatedAt", "SiteLogbookLogsTable"."DeletedAt";

CREATE OR REPLACE RULE "SiteLogbookLogs_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookLogs" DO INSTEAD UPDATE "ForestResources"."SiteLogbookLogsTable"
                                                                SET "SiteLogbookItem" = new."SiteLogbookItem",
                                                                    "LogId"           = new."LogId",
                                                                    "HewingId"        = new."HewingId",
                                                                    "Species"         = new."Species",
                                                                    "MaxDiameter"     = new."MaxDiameter",
                                                                    "MinDiameter"     = new."MinDiameter",
                                                                    "AverageDiameter" = new."AverageDiameter",
                                                                    "Length"          = new."Length",
                                                                    "Volume"          = new."Volume",
                                                                    "Note"            = new."Note",
                                                                    "EvacuationDate"  = new."EvacuationDate",
                                                                    "Lat"             = new."Lat",
                                                                    "Lon"             = new."Lon",
                                                                    "GpsAccu"         = new."GpsAccu",
                                                                    "ObserveAt"       = new."ObserveAt",
                                                                    "Approved"        = new."Approved",
                                                                    "MobileId"        = new."MobileId",
                                                                    "UpdatedAt"       = new."UpdatedAt",
                                                                    "DeletedAt"       = new."DeletedAt"
                                                                WHERE "SiteLogbookLogsTable"."Id" = old."Id"
                                                                RETURNING "SiteLogbookLogsTable"."Id", "SiteLogbookLogsTable"."SiteLogbookItem", "SiteLogbookLogsTable"."LogId", "SiteLogbookLogsTable"."HewingId", "SiteLogbookLogsTable"."Species", "SiteLogbookLogsTable"."MaxDiameter", "SiteLogbookLogsTable"."MinDiameter", "SiteLogbookLogsTable"."AverageDiameter", "SiteLogbookLogsTable"."Length", "SiteLogbookLogsTable"."Volume", "SiteLogbookLogsTable"."Note", "SiteLogbookLogsTable"."EvacuationDate", "SiteLogbookLogsTable"."Lat", "SiteLogbookLogsTable"."Lon", "SiteLogbookLogsTable"."GpsAccu", "SiteLogbookLogsTable"."ObserveAt", "SiteLogbookLogsTable"."Approved", "SiteLogbookLogsTable"."MobileId", "SiteLogbookLogsTable"."CreatedAt", "SiteLogbookLogsTable"."UpdatedAt", "SiteLogbookLogsTable"."DeletedAt";

