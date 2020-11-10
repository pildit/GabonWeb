alter table "ForestResources"."AnnualAllowableCutInventoryTable"
	add "Lat" varchar;
alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add "Lon" varchar;
alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add "GpsAccu" decimal default 0;
alter table "ForestResources"."AnnualAllowableCutInventoryTable"
	add "ObserveAt" timestamp;


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
    aacit."Lat",
    aacit."Lon",
    aacit."GpsAccu",
    aacit."Approved",
    aacit."MobileId",
    aacit."ObserveAt",
    aacit."CreatedAt",
    aacit."UpdatedAt",
    aacit."DeletedAt"
   FROM "ForestResources"."AnnualAllowableCutInventoryTable" aacit;


CREATE RULE "AnnualAllowableCutInventory_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  DELETE FROM "ForestResources"."AnnualAllowableCutInventoryTable"
  WHERE ("ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id");

  CREATE RULE "AnnualAllowableCutInventory_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  INSERT INTO "ForestResources"."AnnualAllowableCutInventoryTable" ("Id", "AnnualAllowableCut", "Species", "Quality", "Parcel", "TreeId", "DiameterBreastHeight", "Geometry","Lat","Lon","GpsAccu", "Approved", "MobileId","ObserveAt", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_AnnualAllowableCutInventory"'::regclass), new."AnnualAllowableCut", new."Species", new."Quality", new."Parcel", new."TreeId", new."DiameterBreastHeight", new."Geometry", new."Lat", new."Lon", new."GpsAccu", new."Approved", new."MobileId", new."ObserveAt", new."CreatedAt", new."UpdatedAt")
  RETURNING "ForestResources"."AnnualAllowableCutInventoryTable"."Id",
    "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Species",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Quality",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Parcel",
    "ForestResources"."AnnualAllowableCutInventoryTable"."TreeId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Geometry",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Lat",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Lon",
    "ForestResources"."AnnualAllowableCutInventoryTable"."GpsAccu",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Approved",
    "ForestResources"."AnnualAllowableCutInventoryTable"."MobileId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."ObserveAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."CreatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."UpdatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DeletedAt";

CREATE RULE "AnnualAllowableCutInventory_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD  UPDATE "ForestResources"."AnnualAllowableCutInventoryTable" SET "AnnualAllowableCut" = new."AnnualAllowableCut", "Species" = new."Species", "Quality" = new."Quality", "Parcel" = new."Parcel", "TreeId" = new."TreeId", "DiameterBreastHeight" = new."DiameterBreastHeight", "Geometry" = new."Geometry", "Lat" = new."Lat", "Lon" = new."Lon", "GpsAccu" = new."GpsAccu", "Approved" = new."Approved", "MobileId" = new."MobileId", "ObserveAt" = new."ObserveAt", "UpdatedAt" = new."UpdatedAt", "DeletedAt" = new."DeletedAt"
  WHERE ("ForestResources"."AnnualAllowableCutInventoryTable"."Id" = old."Id")
  RETURNING "ForestResources"."AnnualAllowableCutInventoryTable"."Id",
    "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Species",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Quality",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Parcel",
    "ForestResources"."AnnualAllowableCutInventoryTable"."TreeId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Geometry",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Lat",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Lon",
    "ForestResources"."AnnualAllowableCutInventoryTable"."GpsAccu",
    "ForestResources"."AnnualAllowableCutInventoryTable"."Approved",
    "ForestResources"."AnnualAllowableCutInventoryTable"."MobileId",
    "ForestResources"."AnnualAllowableCutInventoryTable"."ObserveAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."CreatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."UpdatedAt",
    "ForestResources"."AnnualAllowableCutInventoryTable"."DeletedAt";
