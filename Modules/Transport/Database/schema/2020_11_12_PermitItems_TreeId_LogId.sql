DROP VIEW IF EXISTS "Transportation"."PermitItems";
alter table "Transportation"."PermitItemsTable" rename column "TreeId" to "LogId";

CREATE VIEW "Transportation"."PermitItems"
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

   CREATE RULE "PermitItems_instead_of_delete" AS
    ON DELETE TO "Transportation"."PermitItems" DO INSTEAD  DELETE FROM "Transportation"."PermitItemsTable"
  WHERE ("Transportation"."PermitItemsTable"."Id" = old."Id");

  CREATE RULE "PermitItems_instead_of_insert" AS
    ON INSERT TO "Transportation"."PermitItems" DO INSTEAD  INSERT INTO "Transportation"."PermitItemsTable" ("Id", "Permit", "LogId", "Species", "MinDiameter", "MaxDiameter", "AverageDiameter", "Length", "Volume", "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
  VALUES (nextval('"Transportation"."SEQ_PermitItemsTable"'::regclass), new."Permit", new."LogId", new."Species", new."MinDiameter", new."MaxDiameter", new."AverageDiameter", new."Length", new."Volume", new."MobileId", new."CreatedAt", new."UpdatedAt", new."DeletedAt")
  RETURNING "Transportation"."PermitItemsTable"."Id",
    "Transportation"."PermitItemsTable"."Permit",
    "Transportation"."PermitItemsTable"."LogId",
    "Transportation"."PermitItemsTable"."Species",
    "Transportation"."PermitItemsTable"."MinDiameter",
    "Transportation"."PermitItemsTable"."MaxDiameter",
    "Transportation"."PermitItemsTable"."AverageDiameter",
    "Transportation"."PermitItemsTable"."Length",
    "Transportation"."PermitItemsTable"."Volume",
    "Transportation"."PermitItemsTable"."MobileId",
    "Transportation"."PermitItemsTable"."CreatedAt",
    "Transportation"."PermitItemsTable"."UpdatedAt",
    "Transportation"."PermitItemsTable"."DeletedAt";

    CREATE RULE "PermitItems_instead_of_update" AS
    ON UPDATE TO "Transportation"."PermitItems" DO INSTEAD  UPDATE "Transportation"."PermitItemsTable" SET "Permit" = new."Permit", "LogId" = new."LogId", "Species" = new."Species", "MinDiameter" = new."MinDiameter", "MaxDiameter" = new."MaxDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "MobileId" = new."MobileId", "CreatedAt" = new."CreatedAt", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("Transportation"."PermitItemsTable"."Id" = old."Id")
  RETURNING "Transportation"."PermitItemsTable"."Id",
    "Transportation"."PermitItemsTable"."Permit",
    "Transportation"."PermitItemsTable"."LogId",
    "Transportation"."PermitItemsTable"."Species",
    "Transportation"."PermitItemsTable"."MinDiameter",
    "Transportation"."PermitItemsTable"."MaxDiameter",
    "Transportation"."PermitItemsTable"."AverageDiameter",
    "Transportation"."PermitItemsTable"."Length",
    "Transportation"."PermitItemsTable"."Volume",
    "Transportation"."PermitItemsTable"."MobileId",
    "Transportation"."PermitItemsTable"."CreatedAt",
    "Transportation"."PermitItemsTable"."UpdatedAt",
    "Transportation"."PermitItemsTable"."DeletedAt";
