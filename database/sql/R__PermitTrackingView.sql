create or replace view "Transportation"."PermitTracking"
            ("Id", "User", "Permit", "Lat", "Lon", "GpsAccu", "Geometry", "ObserveAt", "CreatedAt", "UpdatedAt") as
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

alter table "Transportation"."PermitTracking"
    owner to homestead;

CREATE OR REPLACE RULE "PermitTracking_instead_of_delete" AS
    ON DELETE TO "Transportation"."PermitTracking" DO INSTEAD DELETE
                                                              FROM "Transportation"."PermitTrackingTable"
                                                              WHERE "PermitTrackingTable"."Id" = old."Id";

CREATE OR REPLACE RULE "PermitTracking_instead_of_insert" AS
    ON INSERT TO "Transportation"."PermitTracking" DO INSTEAD INSERT INTO "Transportation"."PermitTrackingTable" ("Id",
                                                                                                                  "User",
                                                                                                                  "Permit",
                                                                                                                  "Lat",
                                                                                                                  "Lon",
                                                                                                                  "GpsAccu",
                                                                                                                  "Geometry",
                                                                                                                  "ObserveAt",
                                                                                                                  "CreatedAt",
                                                                                                                  "UpdatedAt")
                                                              VALUES (nextval('"Transportation"."PermitTrackingTable_Id_seq"'::regclass),
                                                                      new."User", new."Permit", new."Lat", new."Lon",
                                                                      new."GpsAccu", new."Geometry", new."ObserveAt",
                                                                      new."CreatedAt", new."UpdatedAt")
                                                              RETURNING "PermitTrackingTable"."Id", "PermitTrackingTable"."User", "PermitTrackingTable"."Permit", "PermitTrackingTable"."Lat", "PermitTrackingTable"."Lon", "PermitTrackingTable"."GpsAccu", "PermitTrackingTable"."Geometry", "PermitTrackingTable"."ObserveAt", "PermitTrackingTable"."CreatedAt", "PermitTrackingTable"."UpdatedAt";

CREATE OR REPLACE RULE "PermitTracking_instead_of_update" AS
    ON UPDATE TO "Transportation"."PermitTracking" DO INSTEAD UPDATE "Transportation"."PermitTrackingTable"
                                                              SET "User"      = new."User",
                                                                  "Lat"       = new."Lat",
                                                                  "Lon"       = new."Lon",
                                                                  "GpsAccu"   = new."GpsAccu",
                                                                  "Geometry"  = new."Geometry",
                                                                  "ObserveAt" = new."ObserveAt",
                                                                  "UpdatedAt" = new."UpdatedAt"
                                                              WHERE "PermitTrackingTable"."Id" = old."Id"
                                                              RETURNING "PermitTrackingTable"."Id", "PermitTrackingTable"."User", "PermitTrackingTable"."Permit", "PermitTrackingTable"."Lat", "PermitTrackingTable"."Lon", "PermitTrackingTable"."GpsAccu", "PermitTrackingTable"."Geometry", "PermitTrackingTable"."ObserveAt", "PermitTrackingTable"."CreatedAt", "PermitTrackingTable"."UpdatedAt";

