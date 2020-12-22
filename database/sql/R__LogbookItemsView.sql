create or replace view "ForestResources"."LogbookItems"
            ("Id", "Logbook", "TreeId", "HewingId", "Species", "MaxDiameter", "MinDiameter", "Length", "Volume", "Lat",
             "Lon", "GpsAccu", "Note", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
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

alter table "ForestResources"."LogbookItems"
    owner to homestead;

CREATE OR REPLACE RULE "LogbookItems_instead_of_delete" AS
    ON DELETE TO "ForestResources"."LogbookItems" DO INSTEAD DELETE
                                                             FROM "ForestResources"."LogbookItemsTable"
                                                             WHERE "LogbookItemsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "LogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."LogbookItems" DO INSTEAD INSERT INTO "ForestResources"."LogbookItemsTable" ("Id",
                                                                                                                "Logbook",
                                                                                                                "TreeId",
                                                                                                                "HewingId",
                                                                                                                "Species",
                                                                                                                "MaxDiameter",
                                                                                                                "MinDiameter",
                                                                                                                "Length",
                                                                                                                "Volume",
                                                                                                                "Lat",
                                                                                                                "Lon",
                                                                                                                "GpsAccu",
                                                                                                                "Note",
                                                                                                                "ObserveAt",
                                                                                                                "Approved",
                                                                                                                "MobileId",
                                                                                                                "CreatedAt",
                                                                                                                "UpdatedAt",
                                                                                                                "DeletedAt")
                                                             VALUES (nextval('"ForestResources"."SEQ_LogbookItemsTable"'::regclass),
                                                                     new."Logbook", new."TreeId", new."HewingId",
                                                                     new."Species", new."MaxDiameter",
                                                                     new."MinDiameter", new."Length", new."Volume",
                                                                     new."Lat", new."Lon", new."GpsAccu", new."Note",
                                                                     new."ObserveAt", new."Approved", new."MobileId",
                                                                     new."CreatedAt", new."UpdatedAt", new."DeletedAt")
                                                             RETURNING "LogbookItemsTable"."Id", "LogbookItemsTable"."Logbook", "LogbookItemsTable"."TreeId", "LogbookItemsTable"."HewingId", "LogbookItemsTable"."Species", "LogbookItemsTable"."MaxDiameter", "LogbookItemsTable"."MinDiameter", "LogbookItemsTable"."Length", "LogbookItemsTable"."Volume", "LogbookItemsTable"."Lat", "LogbookItemsTable"."Lon", "LogbookItemsTable"."GpsAccu", "LogbookItemsTable"."Note", "LogbookItemsTable"."ObserveAt", "LogbookItemsTable"."Approved", "LogbookItemsTable"."MobileId", "LogbookItemsTable"."CreatedAt", "LogbookItemsTable"."UpdatedAt", "LogbookItemsTable"."DeletedAt";

CREATE OR REPLACE RULE "LogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."LogbookItems" DO INSTEAD UPDATE "ForestResources"."LogbookItemsTable"
                                                             SET "TreeId"      = new."TreeId",
                                                                 "HewingId"    = new."HewingId",
                                                                 "Species"     = new."Species",
                                                                 "MaxDiameter" = new."MaxDiameter",
                                                                 "MinDiameter" = new."MinDiameter",
                                                                 "Length"      = new."Length",
                                                                 "Volume"      = new."Volume",
                                                                 "Lat"         = new."Lat",
                                                                 "Lon"         = new."Lon",
                                                                 "GpsAccu"     = new."GpsAccu",
                                                                 "Note"        = new."Note",
                                                                 "ObserveAt"   = new."ObserveAt",
                                                                 "Approved"    = new."Approved",
                                                                 "MobileId"    = new."MobileId",
                                                                 "UpdatedAt"   = new."UpdatedAt",
                                                                 "DeletedAt"   = new."DeletedAt"
                                                             WHERE "LogbookItemsTable"."Id" = old."Id"
                                                             RETURNING "LogbookItemsTable"."Id", "LogbookItemsTable"."Logbook", "LogbookItemsTable"."TreeId", "LogbookItemsTable"."HewingId", "LogbookItemsTable"."Species", "LogbookItemsTable"."MaxDiameter", "LogbookItemsTable"."MinDiameter", "LogbookItemsTable"."Length", "LogbookItemsTable"."Volume", "LogbookItemsTable"."Lat", "LogbookItemsTable"."Lon", "LogbookItemsTable"."GpsAccu", "LogbookItemsTable"."Note", "LogbookItemsTable"."ObserveAt", "LogbookItemsTable"."Approved", "LogbookItemsTable"."MobileId", "LogbookItemsTable"."CreatedAt", "LogbookItemsTable"."UpdatedAt", "LogbookItemsTable"."DeletedAt";

