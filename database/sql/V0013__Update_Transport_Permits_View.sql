drop view if exists "Transportation"."Permits";
create or replace view "Transportation"."Permits"
            ("Id", "PermitNo", "PermitNoMobile", "Concession", "ManagementUnit", "DevelopmentUnit",
             "AnnualAllowableCut", "AnnualAllowableCutName", "ClientCompany", "ClientCompanyName",
             "ConcessionaireCompany", "ConcessionaireCompanyName", "TransporterCompany", "TransporterCompanyName", "User",
             "Email","ProductType", "Status", "DriverName",
             "LicensePlate", "Province", "Destination", "ScanLat", "ScanLon", "ScanGpsAccu", "Lat", "Lon", "GpsAccu",
             "Geometry", "MobileId", "Approved", "ObserveAt", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT per."Id",
       per."PermitNo",
       per."PermitNoMobile",
       per."Concession",
       per."ManagementUnit",
       per."DevelopmentUnit",
       per."AnnualAllowableCut",
       aac."Name" AS "AnnualAllowableCutName",
       per."ClientCompany",
       ccom."Name" AS "ClientCompanyName",
       per."ConcessionaireCompany",
       cscom."Name" as "ConcessionaireCompanyName",
       per."TransporterCompany",
       tcom."Name" as "TransporterCompanyName",
       per."User",
       acc.email as "Email",
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
       per."Approved",
       per."ObserveAt",
       per."CreatedAt",
       per."UpdatedAt",
       per."DeletedAt"
FROM "Transportation"."PermitsTable" per
         LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = per."AnnualAllowableCut"
         LEFT JOIN admin.accounts acc ON per."User" = acc.id
         LEFT JOIN "Taxonomy"."CompaniesTable" ccom ON ccom."Id" = per."ClientCompany"
         LEFT JOIN "Taxonomy"."CompaniesTable" tcom ON tcom."Id" = per."TransporterCompany"
         LEFT JOIN "Taxonomy"."CompaniesTable" cscom ON cscom."Id" = per."ConcessionaireCompany";

CREATE RULE "Permits_instead_of_delete" AS
    ON DELETE TO "Transportation"."Permits"
    DO INSTEAD DELETE
               FROM "Transportation"."PermitsTable"
               WHERE "PermitsTable"."Id" = old."Id";

CREATE RULE "Permits_instead_of_insert" AS
    ON INSERT TO "Transportation"."Permits"
    DO INSTEAD INSERT INTO "Transportation"."PermitsTable" ("Id",
                                                            "PermitNo",
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
                                                            "Approved",
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
                       new."Geometry", new."MobileId", new."Approved",
                       new."ObserveAt", new."CreatedAt", new."UpdatedAt",
                       new."DeletedAt")
               RETURNING "PermitsTable"."Id",
                   "PermitsTable"."PermitNo",
                   "PermitsTable"."PermitNoMobile",
                   "PermitsTable"."Concession",
                   "PermitsTable"."ManagementUnit",
                   "PermitsTable"."DevelopmentUnit",
                   "PermitsTable"."AnnualAllowableCut",
                   (SELECT aac."Name"
                    FROM "ForestResources"."AnnualAllowableCutsTable" aac
                    WHERE "PermitsTable"."AnnualAllowableCut" = aac."Id"
                    LIMIT 1),
                   "PermitsTable"."ClientCompany",
                   (SELECT com."Name"
                    FROM "Taxonomy"."CompaniesTable" com
                    WHERE "PermitsTable"."ClientCompany" = com."Id"
                    LIMIT 1),
                   "PermitsTable"."ConcessionaireCompany",
                   (SELECT com."Name"
                    FROM "Taxonomy"."CompaniesTable" com
                    WHERE "PermitsTable"."ConcessionaireCompany" = com."Id"
                    LIMIT 1),
                   "PermitsTable"."TransporterCompany",
                   (SELECT com."Name"
                    FROM "Taxonomy"."CompaniesTable" com
                    WHERE "PermitsTable"."TransporterCompany" = com."Id"
                    LIMIT 1),
                   "PermitsTable"."User",
                   (select aac.email from admin.accounts aac where "PermitsTable"."User" = aac.id limit 1),
                   "PermitsTable"."ProductType",
                   "PermitsTable"."Status",
                   "PermitsTable"."DriverName",
                   "PermitsTable"."LicensePlate",
                   "PermitsTable"."Province",
                   "PermitsTable"."Destination",
                   "PermitsTable"."ScanLat",
                   "PermitsTable"."ScanLon",
                   "PermitsTable"."ScanGpsAccu",
                   "PermitsTable"."Lat",
                   "PermitsTable"."Lon",
                   "PermitsTable"."GpsAccu",
                   "PermitsTable"."Geometry",
                   "PermitsTable"."MobileId",
                   "PermitsTable"."Approved",
                   "PermitsTable"."ObserveAt",
                   "PermitsTable"."CreatedAt",
                   "PermitsTable"."UpdatedAt",
                   "PermitsTable"."DeletedAt";

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
                                                           "Approved"              = new."Approved",
                                                           "ObserveAt"             = new."ObserveAt",
                                                           "CreatedAt"             = new."CreatedAt",
                                                           "UpdatedAt"             = new."UpdatedAt",
                                                           "DeletedAt"             = new."DeletedAt"
                                                       WHERE "PermitsTable"."Id" = old."Id"
                                                       RETURNING "PermitsTable"."Id",
                                                           "PermitsTable"."PermitNo",
                                                           "PermitsTable"."PermitNoMobile",
                                                           "PermitsTable"."Concession",
                                                           "PermitsTable"."ManagementUnit",
                                                           "PermitsTable"."DevelopmentUnit",
                                                           "PermitsTable"."AnnualAllowableCut",
                                                           (SELECT aac."Name"
                                                            FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                            WHERE "PermitsTable"."AnnualAllowableCut" = aac."Id"
                                                            LIMIT 1),
                                                           "PermitsTable"."ClientCompany",
                                                           (SELECT com."Name"
                                                            FROM "Taxonomy"."CompaniesTable" com
                                                            WHERE "PermitsTable"."ClientCompany" = com."Id"
                                                            LIMIT 1),
                                                           "PermitsTable"."ConcessionaireCompany",
                                                           (SELECT com."Name"
                                                            FROM "Taxonomy"."CompaniesTable" com
                                                            WHERE "PermitsTable"."ConcessionaireCompany" = com."Id"
                                                            LIMIT 1),
                                                           "PermitsTable"."TransporterCompany",
                                                           (SELECT com."Name"
                                                            FROM "Taxonomy"."CompaniesTable" com
                                                            WHERE "PermitsTable"."TransporterCompany" = com."Id"
                                                            LIMIT 1),
                                                           "PermitsTable"."User",
                                                           (select aac.email from admin.accounts aac where "PermitsTable"."User" = aac.id limit 1),
                                                           "PermitsTable"."ProductType",
                                                           "PermitsTable"."Status",
                                                           "PermitsTable"."DriverName",
                                                           "PermitsTable"."LicensePlate",
                                                           "PermitsTable"."Province",
                                                           "PermitsTable"."Destination",
                                                           "PermitsTable"."ScanLat",
                                                           "PermitsTable"."ScanLon",
                                                           "PermitsTable"."ScanGpsAccu",
                                                           "PermitsTable"."Lat",
                                                           "PermitsTable"."Lon",
                                                           "PermitsTable"."GpsAccu",
                                                           "PermitsTable"."Geometry",
                                                           "PermitsTable"."MobileId",
                                                           "PermitsTable"."Approved",
                                                           "PermitsTable"."ObserveAt",
                                                           "PermitsTable"."CreatedAt",
                                                           "PermitsTable"."UpdatedAt",
                                                           "PermitsTable"."DeletedAt";
