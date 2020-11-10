alter table "Transportation"."PermitTrackingTable" rename column "GPSAccuracy" to "GpsAccu";


DROP VIEW "Transportation"."PermitTracking";

CREATE VIEW "Transportation"."PermitTracking"
as
 SELECT pt."Id",
    pt."User",
    pt."Permit",
    pt."Lat",
    pt."Lon",
    pt."GpsAccu",
    pt."Geometry",
    pt."ObserveAt",
    pt."CreatedAt",
    pt."UpdatedAt"
   FROM "Transportation"."PermitTrackingTable" pt;

CREATE RULE "PermitTracking_instead_of_delete" AS
    ON DELETE TO "Transportation"."PermitTracking" DO INSTEAD  DELETE FROM "Transportation"."PermitTrackingTable"
  WHERE ("Transportation"."PermitTrackingTable"."Id" = old."Id");


CREATE RULE "PermitTracking_instead_of_insert" AS
    ON INSERT TO "Transportation"."PermitTracking" DO INSTEAD  INSERT INTO "Transportation"."PermitTrackingTable" ("Id", "User", "Permit", "Lat", "Lon", "GpsAccu", "Geometry", "ObserveAt", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"Transportation"."PermitTrackingTable_Id_seq"'::regclass), new."User", new."Permit", new."Lat", new."Lon", new."GpsAccu", new."Geometry", new."ObserveAt", new."CreatedAt", new."UpdatedAt")
  RETURNING "Transportation"."PermitTrackingTable"."Id",
    "Transportation"."PermitTrackingTable"."User",
    "Transportation"."PermitTrackingTable"."Permit",
    "Transportation"."PermitTrackingTable"."Lat",
    "Transportation"."PermitTrackingTable"."Lon",
    "Transportation"."PermitTrackingTable"."GpsAccu",
    "Transportation"."PermitTrackingTable"."Geometry",
    "Transportation"."PermitTrackingTable"."ObserveAt",
    "Transportation"."PermitTrackingTable"."CreatedAt",
    "Transportation"."PermitTrackingTable"."UpdatedAt";

    CREATE RULE "PermitTracking_instead_of_update" AS
    ON UPDATE TO "Transportation"."PermitTracking" DO INSTEAD  UPDATE "Transportation"."PermitTrackingTable" SET "User" = new."User", "Lat" = new."Lat", "Lon" = new."Lon", "GpsAccu" = new."GpsAccu", "Geometry" = new."Geometry", "ObserveAt" = new."ObserveAt", "UpdatedAt" = new."UpdatedAt"
  WHERE ("Transportation"."PermitTrackingTable"."Id" = old."Id")
  RETURNING "Transportation"."PermitTrackingTable"."Id",
    "Transportation"."PermitTrackingTable"."User",
    "Transportation"."PermitTrackingTable"."Permit",
    "Transportation"."PermitTrackingTable"."Lat",
    "Transportation"."PermitTrackingTable"."Lon",
    "Transportation"."PermitTrackingTable"."GpsAccu",
    "Transportation"."PermitTrackingTable"."Geometry",
    "Transportation"."PermitTrackingTable"."ObserveAt",
    "Transportation"."PermitTrackingTable"."CreatedAt",
    "Transportation"."PermitTrackingTable"."UpdatedAt";
