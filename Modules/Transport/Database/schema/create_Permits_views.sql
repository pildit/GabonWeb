--
-- View Permits
--
DROP VIEW IF EXISTS "Transportation"."Permits";

CREATE VIEW "Transportation"."Permits"
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
FROM "Transportation"."PermitsTable" as per;

-----------
-- RULES --
-----------
CREATE RULE "Permits_instead_of_insert" AS
    ON INSERT TO "Transportation"."Permits" DO INSTEAD
    INSERT INTO "Transportation"."PermitsTable" ("Id",
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
                                                 "Lat",
                                                 "Lon",
                                                 "GpsAccu",
                                                 "Geometry",
                                                 "MobileId",
                                                 "ObserveAt",
                                                 "CreatedAt",
                                                 "UpdatedAt",
                                                 "DeletedAt")
    VALUES (nextval('"Transportation"."PermitsTable_Id_seq"'::regclass),
            new."PermitNo",
            new."PermitNoMobile",
            new."Concession",
            new."ManagementUnit",
            new."DevelopmentUnit",
            new."AnnualAllowableCut",
            new."ClientCompany",
            new."ConcessionaireCompany",
            new."TransporterCompany",
            new."User",
            new."ProductType",
            new."Status",
            new."DriverName",
            new."LicensePlate",
            new."Province",
            new."Destination",
            new."ScanLat",
            new."ScanLon",
            new."ScanGpsAccu",
            new."Lat",
            new."Lon",
            new."GpsAccu",
            new."Geometry",
            new."MobileId",
            new."ObserveAt",
            new."CreatedAt",
            new."UpdatedAt",
            new."DeletedAt")

    RETURNING "Transportation"."PermitsTable"."Id" , "Transportation"."PermitsTable"."PermitNo" , "Transportation"."PermitsTable"."PermitNoMobile" , "Transportation"."PermitsTable"."Concession" , "Transportation"."PermitsTable"."ManagementUnit" , "Transportation"."PermitsTable"."DevelopmentUnit" , "Transportation"."PermitsTable"."AnnualAllowableCut" , "Transportation"."PermitsTable"."ClientCompany" , "Transportation"."PermitsTable"."ConcessionaireCompany" , "Transportation"."PermitsTable"."TransporterCompany" , "Transportation"."PermitsTable"."User" , "Transportation"."PermitsTable"."ProductType" , "Transportation"."PermitsTable"."Status" , "Transportation"."PermitsTable"."DriverName" , "Transportation"."PermitsTable"."LicensePlate" , "Transportation"."PermitsTable"."Province" , "Transportation"."PermitsTable"."Destination" , "Transportation"."PermitsTable"."ScanLat" , "Transportation"."PermitsTable"."ScanLon" , "Transportation"."PermitsTable"."ScanGpsAccu" , "Transportation"."PermitsTable"."Lat" , "Transportation"."PermitsTable"."Lon" , "Transportation"."PermitsTable"."GpsAccu" , "Transportation"."PermitsTable"."Geometry" , "Transportation"."PermitsTable"."MobileId" , "Transportation"."PermitsTable"."ObserveAt" , "Transportation"."PermitsTable"."CreatedAt" , "Transportation"."PermitsTable"."UpdatedAt" , "Transportation"."PermitsTable"."DeletedAt"
;


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


                                                       WHERE ("Transportation"."PermitsTable"."Id" = old."Id")
                                                       RETURNING "Transportation"."PermitsTable"."Id" , "Transportation"."PermitsTable"."PermitNo" , "Transportation"."PermitsTable"."PermitNoMobile" , "Transportation"."PermitsTable"."Concession" , "Transportation"."PermitsTable"."ManagementUnit" , "Transportation"."PermitsTable"."DevelopmentUnit" , "Transportation"."PermitsTable"."AnnualAllowableCut" , "Transportation"."PermitsTable"."ClientCompany" , "Transportation"."PermitsTable"."ConcessionaireCompany" , "Transportation"."PermitsTable"."TransporterCompany" , "Transportation"."PermitsTable"."User" , "Transportation"."PermitsTable"."ProductType" , "Transportation"."PermitsTable"."Status" , "Transportation"."PermitsTable"."DriverName" , "Transportation"."PermitsTable"."LicensePlate" , "Transportation"."PermitsTable"."Province" , "Transportation"."PermitsTable"."Destination" , "Transportation"."PermitsTable"."ScanLat" , "Transportation"."PermitsTable"."ScanLon" , "Transportation"."PermitsTable"."ScanGpsAccu" , "Transportation"."PermitsTable"."Lat" , "Transportation"."PermitsTable"."Lon" , "Transportation"."PermitsTable"."GpsAccu" , "Transportation"."PermitsTable"."Geometry" , "Transportation"."PermitsTable"."MobileId" , "Transportation"."PermitsTable"."ObserveAt" , "Transportation"."PermitsTable"."CreatedAt" , "Transportation"."PermitsTable"."UpdatedAt" , "Transportation"."PermitsTable"."DeletedAt"
;

CREATE RULE "Permits_instead_of_delete" AS
    ON DELETE TO "Transportation"."Permits" DO INSTEAD DELETE
                                                       FROM "Transportation"."PermitsTable"
                                                       WHERE ("Transportation"."PermitsTable"."Id" = old."Id");



--
-- View PermitItems
--
DROP VIEW IF EXISTS "Transportation"."PermitItems";

CREATE VIEW "Transportation"."PermitItems"
as
select peri."Id",
       peri."Permit",
       peri."TreeId",
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
FROM "Transportation"."PermitItemsTable" as peri
;


--
-- Rules
--
CREATE RULE "PermitItems_instead_of_insert" AS
    ON INSERT TO "Transportation"."PermitItems" DO INSTEAD
    INSERT INTO "Transportation"."PermitItemsTable"
    ("Id",
     "Permit",
     "TreeId",
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
    VALUES (nextval('"Transportation"."SEQ_PermitItemsTable"'),
            new."Permit",
            new."TreeId",
            new."Species",
            new."MinDiameter",
            new."MaxDiameter",
            new."AverageDiameter",
            new."Length",
            new."Volume",
            new."MobileId",
            new."CreatedAt",
            new."UpdatedAt",
            new."DeletedAt")
    RETURNING
        "Transportation"."PermitItemsTable"."Id",
        "Transportation"."PermitItemsTable"."Permit",
        "Transportation"."PermitItemsTable"."TreeId",
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
    ON UPDATE TO "Transportation"."PermitItems" DO INSTEAD UPDATE "Transportation"."PermitItemsTable"

                                                           SET "Permit"          = new."Permit",
                                                               "TreeId"          = new."TreeId",
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

                                                           WHERE ("Transportation"."PermitItemsTable"."Id" = old."Id")
                                                           RETURNING
                                                               "Transportation"."PermitItemsTable"."Id",
                                                               "Transportation"."PermitItemsTable"."Permit",
                                                               "Transportation"."PermitItemsTable"."TreeId",
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
CREATE RULE "PermitItems_instead_of_delete" AS
    ON DELETE TO "Transportation"."PermitItems" DO INSTEAD DELETE
                                                           FROM "Transportation"."PermitItemsTable"
                                                           WHERE ("Transportation"."PermitItemsTable"."Id" = old."Id");

