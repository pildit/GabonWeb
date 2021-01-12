-- drop view if exists "Transportation"."Permits";
create or replace view "Transportation"."Permits"
            ("Id", "PermitNo", "PermitNoMobile", "Concession", "ConcessionName", "ManagementUnit", "ManagementUnitName",
             "DevelopmentUnit", "DevelopmentUnitName", "AnnualAllowableCut", "AnnualAllowableCutName", "ClientCompany",
             "ClientCompanyName", "ConcessionaireCompany", "ConcessionaireCompanyName", "TransporterCompany",
             "TransporterCompanyName", "User", "Email", "ProductType", "Status", "DriverName", "LicensePlate",
             "Province", "Destination", "ScanLat", "ScanLon", "ScanGpsAccu", "Lat", "Lon", "GpsAccu", "Geometry",
             "MobileId", "Approved", "ObserveAt", "ImgFront", "ImgBack", "ImgSide", "Park", "TotalItems", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT per."Id",
       per."PermitNo",
       per."PermitNoMobile",
       per."Concession",
       cs."Name"    AS "ConcessionName",
       per."ManagementUnit",
       mu."Name"    AS "ManagementUnitName",
       per."DevelopmentUnit",
       du."Name"    AS "DevelopmentUnitName",
       per."AnnualAllowableCut",
       aac."Name"   AS "AnnualAllowableCutName",
       per."ClientCompany",
       ccom."Name"  AS "ClientCompanyName",
       per."ConcessionaireCompany",
       cscom."Name" AS "ConcessionaireCompanyName",
       per."TransporterCompany",
       tcom."Name"  AS "TransporterCompanyName",
       per."User",
       acc.email    AS "Email",
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
       per."ImgFront",
       per."ImgBack",
       per."ImgSide",
       per."Park",
       (SELECT count(*) FROM "Transportation"."PermitItemsTable" as pit WHERE per."Id" = pit."Permit") as "TotalItems",
       per."CreatedAt",
       per."UpdatedAt",
       per."DeletedAt"
FROM "Transportation"."PermitsTable" per
         LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = per."AnnualAllowableCut"
         LEFT JOIN admin.accounts acc ON per."User" = acc.id
         LEFT JOIN "ForestResources"."ConcessionsTable" cs ON per."Concession" = cs."Id"
         LEFT JOIN "ForestResources"."ManagementUnitsTable" mu ON per."ManagementUnit" = mu."Id"
         LEFT JOIN "ForestResources"."DevelopmentUnitsTable" du ON per."DevelopmentUnit" = du."Id"
         LEFT JOIN "Taxonomy"."CompaniesTable" ccom ON ccom."Id" = per."ClientCompany"
         LEFT JOIN "Taxonomy"."CompaniesTable" tcom ON tcom."Id" = per."TransporterCompany"
         LEFT JOIN "Taxonomy"."CompaniesTable" cscom ON cscom."Id" = per."ConcessionaireCompany";


CREATE OR REPLACE RULE "Permits_instead_of_delete" AS
    ON DELETE TO "Transportation"."Permits" DO INSTEAD DELETE
                                                       FROM "Transportation"."PermitsTable"
                                                       WHERE "PermitsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "Permits_instead_of_insert" AS
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
                                                                                                    "Approved",
                                                                                                    "ObserveAt",
                                                                                                    "ImgFront",
                                                                                                    "ImgBack",
                                                                                                    "ImgSide",
                                                                                                    "Park",
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
                                                               new."ObserveAt",new."ImgFront",new."ImgBack",new."ImgSide",new."Park", new."CreatedAt", new."UpdatedAt",
                                                               new."DeletedAt")
                                                       RETURNING "PermitsTable"."Id", "PermitsTable"."PermitNo", "PermitsTable"."PermitNoMobile", "PermitsTable"."Concession", (SELECT cs."Name"
                                                                                                                                                                                FROM "ForestResources"."ConcessionsTable" cs
                                                                                                                                                                                WHERE "PermitsTable"."Concession" = cs."Id"
                                                                                                                                                                                LIMIT 1) AS "Name", "PermitsTable"."ManagementUnit", (SELECT mu."Name"
                                                                                                                                                                                                                                      FROM "ForestResources"."ManagementUnitsTable" mu
                                                                                                                                                                                                                                      WHERE "PermitsTable"."Concession" = mu."Id"
                                                                                                                                                                                                                                      LIMIT 1) AS "Name", "PermitsTable"."DevelopmentUnit", (SELECT du."Name"
                                                                                                                                                                                                                                                                                             FROM "ForestResources"."DevelopmentUnitsTable" du
                                                                                                                                                                                                                                                                                             WHERE "PermitsTable"."Concession" = du."Id"
                                                                                                                                                                                                                                                                                             LIMIT 1) AS "Name", "PermitsTable"."AnnualAllowableCut", (SELECT aac."Name"
                                                                                                                                                                                                                                                                                                                                                       FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                                                                                                                                                                                                                                                                                                       WHERE "PermitsTable"."AnnualAllowableCut" = aac."Id"
                                                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS "Name", "PermitsTable"."ClientCompany", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                            FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                            WHERE "PermitsTable"."ClientCompany" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                            LIMIT 1) AS "Name", "PermitsTable"."ConcessionaireCompany", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                         FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                                                                                         WHERE "PermitsTable"."ConcessionaireCompany" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                         LIMIT 1) AS "Name", "PermitsTable"."TransporterCompany", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   WHERE "PermitsTable"."TransporterCompany" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   LIMIT 1) AS "Name", "PermitsTable"."User", (SELECT aac.email
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               FROM admin.accounts aac
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               WHERE "PermitsTable"."User" = aac.id
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               LIMIT 1) AS email, "PermitsTable"."ProductType", "PermitsTable"."Status", "PermitsTable"."DriverName", "PermitsTable"."LicensePlate", "PermitsTable"."Province", "PermitsTable"."Destination", "PermitsTable"."ScanLat", "PermitsTable"."ScanLon", "PermitsTable"."ScanGpsAccu", "PermitsTable"."Lat", "PermitsTable"."Lon", "PermitsTable"."GpsAccu", "PermitsTable"."Geometry", "PermitsTable"."MobileId", "PermitsTable"."Approved", "PermitsTable"."ObserveAt", "PermitsTable"."ImgFront", "PermitsTable"."ImgBack", "PermitsTable"."ImgSide", "PermitsTable"."Park", (SELECT count(*) FROM "Transportation"."PermitItemsTable" as pit WHERE "PermitsTable"."Id" = pit."Permit") as "TotalItems", "PermitsTable"."CreatedAt", "PermitsTable"."UpdatedAt", "PermitsTable"."DeletedAt";

CREATE OR REPLACE RULE "Permits_instead_of_update" AS
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
                                                           "ImgFront"             = new."ImgFront",
                                                           "ImgBack"             = new."ImgBack",
                                                           "ImgSide"             = new."ImgSide",
                                                           "Park"               = new."Park",
                                                           "CreatedAt"             = new."CreatedAt",
                                                           "UpdatedAt"             = new."UpdatedAt",
                                                           "DeletedAt"             = new."DeletedAt"
                                                       WHERE "PermitsTable"."Id" = old."Id"
                                                       RETURNING "PermitsTable"."Id", "PermitsTable"."PermitNo", "PermitsTable"."PermitNoMobile", "PermitsTable"."Concession", (SELECT cs."Name"
                                                                                                                                                                                FROM "ForestResources"."ConcessionsTable" cs
                                                                                                                                                                                WHERE "PermitsTable"."Concession" = cs."Id"
                                                                                                                                                                                LIMIT 1) AS "Name", "PermitsTable"."ManagementUnit", (SELECT mu."Name"
                                                                                                                                                                                                                                      FROM "ForestResources"."ManagementUnitsTable" mu
                                                                                                                                                                                                                                      WHERE "PermitsTable"."Concession" = mu."Id"
                                                                                                                                                                                                                                      LIMIT 1) AS "Name", "PermitsTable"."DevelopmentUnit", (SELECT du."Name"
                                                                                                                                                                                                                                                                                             FROM "ForestResources"."DevelopmentUnitsTable" du
                                                                                                                                                                                                                                                                                             WHERE "PermitsTable"."Concession" = du."Id"
                                                                                                                                                                                                                                                                                             LIMIT 1) AS "Name", "PermitsTable"."AnnualAllowableCut", (SELECT aac."Name"
                                                                                                                                                                                                                                                                                                                                                       FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                                                                                                                                                                                                                                                                                                       WHERE "PermitsTable"."AnnualAllowableCut" = aac."Id"
                                                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS "Name", "PermitsTable"."ClientCompany", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                            FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                            WHERE "PermitsTable"."ClientCompany" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                            LIMIT 1) AS "Name", "PermitsTable"."ConcessionaireCompany", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                         FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                                                                                         WHERE "PermitsTable"."ConcessionaireCompany" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                         LIMIT 1) AS "Name", "PermitsTable"."TransporterCompany", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   WHERE "PermitsTable"."TransporterCompany" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   LIMIT 1) AS "Name", "PermitsTable"."User", (SELECT aac.email
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               FROM admin.accounts aac
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               WHERE "PermitsTable"."User" = aac.id
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               LIMIT 1) AS email, "PermitsTable"."ProductType", "PermitsTable"."Status", "PermitsTable"."DriverName", "PermitsTable"."LicensePlate", "PermitsTable"."Province", "PermitsTable"."Destination", "PermitsTable"."ScanLat", "PermitsTable"."ScanLon", "PermitsTable"."ScanGpsAccu", "PermitsTable"."Lat", "PermitsTable"."Lon", "PermitsTable"."GpsAccu", "PermitsTable"."Geometry", "PermitsTable"."MobileId", "PermitsTable"."Approved", "PermitsTable"."ObserveAt", "PermitsTable"."ImgFront", "PermitsTable"."ImgBack", "PermitsTable"."ImgSide", "PermitsTable"."Park", (SELECT count(*) FROM "Transportation"."PermitItemsTable" as pit WHERE "PermitsTable"."Id" = pit."Permit") as "TotalItems", "PermitsTable"."CreatedAt", "PermitsTable"."UpdatedAt", "PermitsTable"."DeletedAt";

