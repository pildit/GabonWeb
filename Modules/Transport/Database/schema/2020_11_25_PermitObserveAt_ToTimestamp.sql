DROP VIEW "Transportation"."Permits";

alter table "Transportation"."PermitsTable" alter column "ObserveAt" type timestamp using "ObserveAt"::timestamp;

alter table "Transportation"."PermitsTable" alter column "ObserveAt" set not null;

create view "Transportation"."Permits"
            ("Id", "PermitNo", "PermitNoMobile", "Concession", "ManagementUnit", "DevelopmentUnit",
             "AnnualAllowableCut", "ClientCompany", "ConcessionaireCompany", "TransporterCompany", "User",
             "ProductType", "Status", "DriverName", "LicensePlate", "Province", "Destination", "ScanLat", "ScanLon",
             "ScanGpsAccu", "Lat", "Lon", "GpsAccu", "Geometry", "MobileId", "ObserveAt", "CreatedAt", "UpdatedAt",
             "DeletedAt")
as
SELECT per."Id",
       per."PermitNo",
       per."PermitNoMobile",
       per."Concession",
       per."ManagementUnit",
       per."DevelopmentUnit",
       per."AnnualAllowableCut",
       per."ClientCompany",
       per."ConcessionaireCompany",
       per."TransporterCompany",
       per."User",
       per."ProductType",
       per."Status",
       per."DriverName",
       per."LicensePlate",
       per."Province",
       per."Destination",
       per."ScanLat",
       per."ScanLon",
       per."ScanGpsAccu",
       per."Lat",
       per."Lon",
       per."GpsAccu",
       per."Geometry",
       per."MobileId",
       per."ObserveAt",
       per."CreatedAt",
       per."UpdatedAt",
       per."DeletedAt"
FROM "Transportation"."PermitsTable" per;

CREATE RULE "Permits_instead_of_delete" AS
    ON DELETE TO "Transportation"."Permits" DO INSTEAD DELETE
                                                       FROM "Transportation"."PermitsTable"
                                                       WHERE "PermitsTable"."Id" = old."Id";

CREATE RULE "Permits_instead_of_insert" AS
    ON INSERT TO "Transportation"."Permits" DO INSTEAD INSERT INTO "Transportation"."PermitsTable" ("Id", "PermitNo",
                                                                                                    "PermitNoMobile",
                                                                                                    "Concession",
                                                                                                    "ManagementUnit",
                                                                                                    "DevelopmentUnit",
                                                                                                    "AnnualAllowableCut",
                                                                                                    "ClientCompany",
                                                                                                    "ConcessionaireCompany",
                                                                                                    "TransporterCompany",
                                                                                                    "User",
                                                                                                    "ProductType",
                                                                                                    "Status",
                                                                                                    "DriverName",
                                                                                                    "LicensePlate",
                                                                                                    "Province",
                                                                                                    "Destination",
                                                                                                    "ScanLat",
                                                                                                    "ScanLon",
                                                                                                    "ScanGpsAccu",
                                                                                                    "Lat", "Lon",
                                                                                                    "GpsAccu",
                                                                                                    "Geometry",
                                                                                                    "MobileId",
                                                                                                    "ObserveAt",
                                                                                                    "CreatedAt",
                                                                                                    "UpdatedAt",
                                                                                                    "DeletedAt")
                                                       VALUES (nextval('"Transportation"."PermitsTable_Id_seq"'::regclass),
                                                               new."PermitNo", new."PermitNoMobile", new."Concession",
                                                               new."ManagementUnit", new."DevelopmentUnit",
                                                               new."AnnualAllowableCut", new."ClientCompany",
                                                               new."ConcessionaireCompany", new."TransporterCompany",
                                                               new."User", new."ProductType", new."Status",
                                                               new."DriverName", new."LicensePlate", new."Province",
                                                               new."Destination", new."ScanLat", new."ScanLon",
                                                               new."ScanGpsAccu", new."Lat", new."Lon", new."GpsAccu",
                                                               new."Geometry", new."MobileId", new."ObserveAt",
                                                               new."CreatedAt", new."UpdatedAt", new."DeletedAt")
                                                       RETURNING "PermitsTable"."Id", "PermitsTable"."PermitNo", "PermitsTable"."PermitNoMobile", "PermitsTable"."Concession", "PermitsTable"."ManagementUnit", "PermitsTable"."DevelopmentUnit", "PermitsTable"."AnnualAllowableCut", "PermitsTable"."ClientCompany", "PermitsTable"."ConcessionaireCompany", "PermitsTable"."TransporterCompany", "PermitsTable"."User", "PermitsTable"."ProductType", "PermitsTable"."Status", "PermitsTable"."DriverName", "PermitsTable"."LicensePlate", "PermitsTable"."Province", "PermitsTable"."Destination", "PermitsTable"."ScanLat", "PermitsTable"."ScanLon", "PermitsTable"."ScanGpsAccu", "PermitsTable"."Lat", "PermitsTable"."Lon", "PermitsTable"."GpsAccu", "PermitsTable"."Geometry", "PermitsTable"."MobileId", "PermitsTable"."ObserveAt", "PermitsTable"."CreatedAt", "PermitsTable"."UpdatedAt", "PermitsTable"."DeletedAt";

CREATE RULE "Permits_instead_of_update" AS
    ON UPDATE TO "Transportation"."Permits" DO INSTEAD UPDATE "Transportation"."PermitsTable"
                                                       SET "PermitNo"              = new."PermitNo",
                                                           "PermitNoMobile"        = new."PermitNoMobile",
                                                           "Concession"            = new."Concession",
                                                           "ManagementUnit"        = new."ManagementUnit",
                                                           "DevelopmentUnit"       = new."DevelopmentUnit",
                                                           "AnnualAllowableCut"    = new."AnnualAllowableCut",
                                                           "ClientCompany"         = new."ClientCompany",
                                                           "ConcessionaireCompany" = new."ConcessionaireCompany",
                                                           "TransporterCompany"    = new."TransporterCompany",
                                                           "User"                  = new."User",
                                                           "ProductType"           = new."ProductType",
                                                           "Status"                = new."Status",
                                                           "DriverName"            = new."DriverName",
                                                           "LicensePlate"          = new."LicensePlate",
                                                           "Province"              = new."Province",
                                                           "Destination"           = new."Destination",
                                                           "ScanLat"               = new."ScanLat",
                                                           "ScanLon"               = new."ScanLon",
                                                           "ScanGpsAccu"           = new."ScanGpsAccu",
                                                           "Lat"                   = new."Lat",
                                                           "Lon"                   = new."Lon",
                                                           "GpsAccu"               = new."GpsAccu",
                                                           "Geometry"              = new."Geometry",
                                                           "MobileId"              = new."MobileId",
                                                           "ObserveAt"             = new."ObserveAt",
                                                           "CreatedAt"             = new."CreatedAt",
                                                           "UpdatedAt"             = new."UpdatedAt",
                                                           "DeletedAt"             = new."DeletedAt"
                                                       WHERE "PermitsTable"."Id" = old."Id"
                                                       RETURNING "PermitsTable"."Id", "PermitsTable"."PermitNo", "PermitsTable"."PermitNoMobile", "PermitsTable"."Concession", "PermitsTable"."ManagementUnit", "PermitsTable"."DevelopmentUnit", "PermitsTable"."AnnualAllowableCut", "PermitsTable"."ClientCompany", "PermitsTable"."ConcessionaireCompany", "PermitsTable"."TransporterCompany", "PermitsTable"."User", "PermitsTable"."ProductType", "PermitsTable"."Status", "PermitsTable"."DriverName", "PermitsTable"."LicensePlate", "PermitsTable"."Province", "PermitsTable"."Destination", "PermitsTable"."ScanLat", "PermitsTable"."ScanLon", "PermitsTable"."ScanGpsAccu", "PermitsTable"."Lat", "PermitsTable"."Lon", "PermitsTable"."GpsAccu", "PermitsTable"."Geometry", "PermitsTable"."MobileId", "PermitsTable"."ObserveAt", "PermitsTable"."CreatedAt", "PermitsTable"."UpdatedAt", "PermitsTable"."DeletedAt";
