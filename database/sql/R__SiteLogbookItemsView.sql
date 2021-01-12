drop view "ForestResources"."SiteLogbookItems";
create or replace view "ForestResources"."SiteLogbookItems"
            ("Id", "SiteLogbook", "Species", "SpeciesLatinName", "SpeciesCommonName", "HewingId", "Date", "MaxDiameter", "MinDiameter",
             "AverageDiameter", "Length", "Volume", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt",
             "DeletedAt")
as
SELECT slbi."Id",
       slbi."SiteLogbook",
       slbi."Species",
       s."LatinName" AS "SpeciesLatinName",
       s."CommonName" AS "SpeciesCommonName",
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
FROM "ForestResources"."SiteLogbookItemsTable" slbi
         LEFT JOIN "Taxonomy"."SpeciesTable" s ON slbi."Species" = s."Id";


CREATE OR REPLACE RULE "SiteLogbookItems_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbookItems" DO INSTEAD DELETE
                                                                 FROM "ForestResources"."SiteLogbookItemsTable"
                                                                 WHERE "SiteLogbookItemsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "SiteLogbookItems_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbookItems" DO INSTEAD INSERT INTO "ForestResources"."SiteLogbookItemsTable" ("Id",
                                                                                                                        "SiteLogbook",
                                                                                                                        "Species",
                                                                                                                        "HewingId",
                                                                                                                        "Date",
                                                                                                                        "MaxDiameter",
                                                                                                                        "MinDiameter",
                                                                                                                        "AverageDiameter",
                                                                                                                        "Length",
                                                                                                                        "Volume",
                                                                                                                        "ObserveAt",
                                                                                                                        "Approved",
                                                                                                                        "MobileId",
                                                                                                                        "CreatedAt",
                                                                                                                        "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_SiteLogbookItemsTable"'::regclass),
                                                                         new."SiteLogbook", new."Species",
                                                                         new."HewingId", new."Date", new."MaxDiameter",
                                                                         new."MinDiameter", new."AverageDiameter",
                                                                         new."Length", new."Volume", new."ObserveAt",
                                                                         new."Approved", new."MobileId",
                                                                         new."CreatedAt", new."UpdatedAt")
                                                                 RETURNING "SiteLogbookItemsTable"."Id", "SiteLogbookItemsTable"."SiteLogbook", "SiteLogbookItemsTable"."Species", (SELECT s."LatinName"
                                                                                                                                                                                    FROM "Taxonomy"."SpeciesTable" s
                                                                                                                                                                                    WHERE s."Id" = "SiteLogbookItemsTable"."Species"
                                                                                                                                                                                    LIMIT 1) AS "LatinName", (SELECT s."CommonName"
                                                                                                                                                                                    FROM "Taxonomy"."SpeciesTable" s
                                                                                                                                                                                    WHERE s."Id" = "SiteLogbookItemsTable"."Species"
                                                                                                                                                                                    LIMIT 1) AS "CommonName", "SiteLogbookItemsTable"."HewingId", "SiteLogbookItemsTable"."Date", "SiteLogbookItemsTable"."MaxDiameter", "SiteLogbookItemsTable"."MinDiameter", "SiteLogbookItemsTable"."AverageDiameter", "SiteLogbookItemsTable"."Length", "SiteLogbookItemsTable"."Volume", "SiteLogbookItemsTable"."ObserveAt", "SiteLogbookItemsTable"."Approved", "SiteLogbookItemsTable"."MobileId", "SiteLogbookItemsTable"."CreatedAt", "SiteLogbookItemsTable"."UpdatedAt", "SiteLogbookItemsTable"."DeletedAt";

CREATE OR REPLACE RULE "SiteLogbookItems_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbookItems" DO INSTEAD UPDATE "ForestResources"."SiteLogbookItemsTable"
                                                                 SET "Species"         = new."Species",
                                                                     "HewingId"        = new."HewingId",
                                                                     "Date"            = new."Date",
                                                                     "MaxDiameter"     = new."MaxDiameter",
                                                                     "MinDiameter"     = new."MinDiameter",
                                                                     "AverageDiameter" = new."AverageDiameter",
                                                                     "Length"          = new."Length",
                                                                     "Volume"          = new."Volume",
                                                                     "ObserveAt"       = new."ObserveAt",
                                                                     "Approved"        = new."Approved",
                                                                     "MobileId"        = new."MobileId",
                                                                     "UpdatedAt"       = new."UpdatedAt",
                                                                     "DeletedAt"       = new."DeletedAt"
                                                                 WHERE "SiteLogbookItemsTable"."Id" = old."Id"
                                                                 RETURNING "SiteLogbookItemsTable"."Id", "SiteLogbookItemsTable"."SiteLogbook", "SiteLogbookItemsTable"."Species", (SELECT s."LatinName"
                                                                                                                                                                                    FROM "Taxonomy"."SpeciesTable" s
                                                                                                                                                                                    WHERE s."Id" = "SiteLogbookItemsTable"."Species"
                                                                                                                                                                                    LIMIT 1) AS "LatinName", (SELECT s."CommonName"
                                                                                                                                                                                    FROM "Taxonomy"."SpeciesTable" s
                                                                                                                                                                                    WHERE s."Id" = "SiteLogbookItemsTable"."Species"
                                                                                                                                                                                    LIMIT 1) AS "CommonName", "SiteLogbookItemsTable"."HewingId", "SiteLogbookItemsTable"."Date", "SiteLogbookItemsTable"."MaxDiameter", "SiteLogbookItemsTable"."MinDiameter", "SiteLogbookItemsTable"."AverageDiameter", "SiteLogbookItemsTable"."Length", "SiteLogbookItemsTable"."Volume", "SiteLogbookItemsTable"."ObserveAt", "SiteLogbookItemsTable"."Approved", "SiteLogbookItemsTable"."MobileId", "SiteLogbookItemsTable"."CreatedAt", "SiteLogbookItemsTable"."UpdatedAt", "SiteLogbookItemsTable"."DeletedAt";

