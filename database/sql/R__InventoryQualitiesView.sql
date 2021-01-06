create or replace view "ForestResources"."InventoryQualities"
            ("Id", "Description", "Value", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT iqt."Id",
       iqt."Description",
       iqt."Value",
       iqt."User",
       acc.email AS "Email",
       iqt."CreatedAt",
       iqt."UpdatedAt",
       iqt."DeletedAt"
FROM "ForestResources"."InventoryQualitiesTable" iqt
         LEFT JOIN admin.accounts acc ON acc.id = iqt."User";

CREATE OR REPLACE RULE "InventoryQualities_instead_of_delete" AS
    ON DELETE TO "ForestResources"."InventoryQualities" DO INSTEAD DELETE
                                                                   FROM "ForestResources"."InventoryQualitiesTable"
                                                                   WHERE "InventoryQualitiesTable"."Id" = old."Id";

CREATE OR REPLACE RULE "InventoryQualities_instead_of_insert" AS
    ON INSERT TO "ForestResources"."InventoryQualities" DO INSTEAD INSERT INTO "ForestResources"."InventoryQualitiesTable" ("Id", "Description", "Value", "CreatedAt", "User")
                                                                   VALUES (nextval('"ForestResources"."SEQ_InventoryQualities"'::regclass),
                                                                           new."Description", new."Value",
                                                                           new."CreatedAt", new."User")
                                                                   RETURNING "InventoryQualitiesTable"."Id", "InventoryQualitiesTable"."Description", "InventoryQualitiesTable"."Value", "InventoryQualitiesTable"."User", (SELECT acc.email
                                                                                                                                                                                                                            FROM admin.accounts acc
                                                                                                                                                                                                                            WHERE "InventoryQualitiesTable"."User" = acc.id
                                                                                                                                                                                                                            LIMIT 1) AS email, "InventoryQualitiesTable"."CreatedAt", "InventoryQualitiesTable"."UpdatedAt", "InventoryQualitiesTable"."DeletedAt";

CREATE OR REPLACE RULE "InventoryQualities_instead_of_update" AS
    ON UPDATE TO "ForestResources"."InventoryQualities" DO INSTEAD UPDATE "ForestResources"."InventoryQualitiesTable"
                                                                   SET "Description" = new."Description",
                                                                       "Value"       = new."Value",
                                                                       "UpdatedAt"   = new."UpdatedAt",
                                                                       "DeletedAt"   = new."DeletedAt"
                                                                   WHERE "InventoryQualitiesTable"."Id" = old."Id"
                                                                   RETURNING "InventoryQualitiesTable"."Id", "InventoryQualitiesTable"."Description", "InventoryQualitiesTable"."Value", "InventoryQualitiesTable"."User", (SELECT acc.email
                                                                                                                                                                                                                            FROM admin.accounts acc
                                                                                                                                                                                                                            WHERE "InventoryQualitiesTable"."User" = acc.id
                                                                                                                                                                                                                            LIMIT 1) AS email, "InventoryQualitiesTable"."CreatedAt", "InventoryQualitiesTable"."UpdatedAt", "InventoryQualitiesTable"."DeletedAt";

