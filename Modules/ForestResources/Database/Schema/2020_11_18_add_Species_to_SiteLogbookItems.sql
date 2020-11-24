alter table "ForestResources"."SiteLogbookItemsTable"
    add "Species" int not null DEFAULT('0')
;

alter table "ForestResources"."SiteLogbookItemsTable"
    add constraint "FK_SiteLogbookItemsTable_Species"
        foreign key
            (
             "Species"
                )
            references "Taxonomy"."SpeciesTable"("Id")
;


DROP VIEW "ForestResources"."SiteLogbookItems";

CREATE VIEW "ForestResources"."SiteLogbookItems"
as
SELECT slbi."Id",
       slbi."SiteLogbook",
       slbi."Species",
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
    ON INSERT TO "ForestResources"."SiteLogbookItems" DO INSTEAD  INSERT INTO "ForestResources"."SiteLogbookItemsTable" ("Id", "SiteLogbook", "Species", "HewingId", "Date", "MaxDiameter", "MinDiameter", "AverageDiameter", "Length", "Volume", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt")
                                                                  VALUES (nextval('"ForestResources"."SEQ_SiteLogbookItemsTable"'::regclass), new."SiteLogbook", new."Species", new."HewingId", new."Date", new."MaxDiameter", new."MinDiameter", new."AverageDiameter", new."Length", new."Volume", new."ObserveAt", new."Approved", new."MobileId", new."CreatedAt", new."UpdatedAt")
                                                                  RETURNING "ForestResources"."SiteLogbookItemsTable"."Id",
                                                                      "ForestResources"."SiteLogbookItemsTable"."SiteLogbook",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Species",
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
    ON UPDATE TO "ForestResources"."SiteLogbookItems" DO INSTEAD  UPDATE "ForestResources"."SiteLogbookItemsTable" SET "Species" = new."Species","HewingId" = new."HewingId", "Date" = new."Date", "MaxDiameter" = new."MaxDiameter", "MinDiameter" = new."MinDiameter", "AverageDiameter" = new."AverageDiameter", "Length" = new."Length", "Volume" = new."Volume", "ObserveAt" = new."ObserveAt", "Approved" = new."Approved", "MobileId" = new."MobileId", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
                                                                  WHERE ("ForestResources"."SiteLogbookItemsTable"."Id" = old."Id")
                                                                  RETURNING "ForestResources"."SiteLogbookItemsTable"."Id",
                                                                      "ForestResources"."SiteLogbookItemsTable"."SiteLogbook",
                                                                      "ForestResources"."SiteLogbookItemsTable"."Species",
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

