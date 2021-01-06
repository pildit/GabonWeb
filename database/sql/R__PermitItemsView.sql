create or replace view "Transportation"."PermitItems"
            ("Id", "Permit", "LogId", "Species", "MinDiameter", "MaxDiameter", "AverageDiameter", "Length", "Volume",
             "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT peri."Id",
       peri."Permit",
       peri."LogId",
       peri."Species",
       peri."MinDiameter",
       peri."MaxDiameter",
       peri."AverageDiameter",
       peri."Length",
       peri."Volume",
       peri."MobileId",
       peri."CreatedAt",
       peri."UpdatedAt",
       peri."DeletedAt"
FROM "Transportation"."PermitItemsTable" peri;


CREATE OR REPLACE RULE "PermitItems_instead_of_delete" AS
    ON DELETE TO "Transportation"."PermitItems" DO INSTEAD DELETE
                                                           FROM "Transportation"."PermitItemsTable"
                                                           WHERE "PermitItemsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "PermitItems_instead_of_insert" AS
    ON INSERT TO "Transportation"."PermitItems" DO INSTEAD INSERT INTO "Transportation"."PermitItemsTable" ("Id",
                                                                                                            "Permit",
                                                                                                            "LogId",
                                                                                                            "Species",
                                                                                                            "MinDiameter",
                                                                                                            "MaxDiameter",
                                                                                                            "AverageDiameter",
                                                                                                            "Length",
                                                                                                            "Volume",
                                                                                                            "MobileId",
                                                                                                            "CreatedAt",
                                                                                                            "UpdatedAt",
                                                                                                            "DeletedAt")
                                                           VALUES (nextval('"Transportation"."SEQ_PermitItemsTable"'::regclass),
                                                                   new."Permit", new."LogId", new."Species",
                                                                   new."MinDiameter", new."MaxDiameter",
                                                                   new."AverageDiameter", new."Length", new."Volume",
                                                                   new."MobileId", new."CreatedAt", new."UpdatedAt",
                                                                   new."DeletedAt")
                                                           RETURNING "PermitItemsTable"."Id", "PermitItemsTable"."Permit", "PermitItemsTable"."LogId", "PermitItemsTable"."Species", "PermitItemsTable"."MinDiameter", "PermitItemsTable"."MaxDiameter", "PermitItemsTable"."AverageDiameter", "PermitItemsTable"."Length", "PermitItemsTable"."Volume", "PermitItemsTable"."MobileId", "PermitItemsTable"."CreatedAt", "PermitItemsTable"."UpdatedAt", "PermitItemsTable"."DeletedAt";

CREATE OR REPLACE RULE "PermitItems_instead_of_update" AS
    ON UPDATE TO "Transportation"."PermitItems" DO INSTEAD UPDATE "Transportation"."PermitItemsTable"
                                                           SET "Permit"          = new."Permit",
                                                               "LogId"           = new."LogId",
                                                               "Species"         = new."Species",
                                                               "MinDiameter"     = new."MinDiameter",
                                                               "MaxDiameter"     = new."MaxDiameter",
                                                               "AverageDiameter" = new."AverageDiameter",
                                                               "Length"          = new."Length",
                                                               "Volume"          = new."Volume",
                                                               "MobileId"        = new."MobileId",
                                                               "CreatedAt"       = new."CreatedAt",
                                                               "UpdatedAt"       = new."UpdatedAt",
                                                               "DeletedAt"       = new."DeletedAt"
                                                           WHERE "PermitItemsTable"."Id" = old."Id"
                                                           RETURNING "PermitItemsTable"."Id", "PermitItemsTable"."Permit", "PermitItemsTable"."LogId", "PermitItemsTable"."Species", "PermitItemsTable"."MinDiameter", "PermitItemsTable"."MaxDiameter", "PermitItemsTable"."AverageDiameter", "PermitItemsTable"."Length", "PermitItemsTable"."Volume", "PermitItemsTable"."MobileId", "PermitItemsTable"."CreatedAt", "PermitItemsTable"."UpdatedAt", "PermitItemsTable"."DeletedAt";

