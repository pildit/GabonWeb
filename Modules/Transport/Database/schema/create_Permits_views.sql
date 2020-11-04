--
-- View Permits
--
DROP VIEW IF EXISTS "Transportation"."Permits";

CREATE VIEW "Transportation"."Permits"
as
SELECT per."Id",
       per."Recdate",
       per."Obsdate",
       per."Appuser",
       per."Lat",
       per."Lon",
       per."GpsAccu",
       per."PermitNo",
       per."HarvestName",
       per."ClientName",
       per."ConcessionName",
       per."TransportComp",
       per."LicensePlate",
       per."Destination",
       per."ManagementUnit",
       per."OperationalUnit",
       per."AnnualOperationalUnit",
       per."Note",
       per."TheGeom",
       per."PoductType",
       per."PermitStatus",
       per."VerifiedBy",
       per."TransportBy",
       per."GeneratedBy",
       per."ScanLat",
       per."ScanLon",
       per."ScanGpsAccu",
       per."Photos",
       per."Farmer",
       per."FirstProvince",
       per."MobileId",
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
                                                 "Recdate",
                                                 "Obsdate",
                                                 "Appuser",
                                                 "Lat",
                                                 "Lon",
                                                 "GpsAccu",
                                                 "PermitNo",
                                                 "HarvestName",
                                                 "ClientName",
                                                 "ConcessionName",
                                                 "TransportComp",
                                                 "LicensePlate",
                                                 "Destination",
                                                 "ManagementUnit",
                                                 "OperationalUnit",
                                                 "AnnualOperationalUnit",
                                                 "Note",
                                                 "TheGeom",
                                                 "PoductType",
                                                 "PermitStatus",
                                                 "VerifiedBy",
                                                 "TransportBy",
                                                 "GeneratedBy",
                                                 "ScanLat",
                                                 "ScanLon",
                                                 "ScanGpsAccu",
                                                 "Photos",
                                                 "Farmer",
                                                 "FirstProvince",
                                                 "MobileId",
                                                 "CreatedAt",
                                                 "UpdatedAt",
                                                 "DeletedAt")
    VALUES (nextval('"Transportation"."PermitsTable_Id_seq"'::regclass),
            new."Recdate",
            new."Obsdate",
            new."Appuser",
            new."Lat",
            new."Lon",
            new."GpsAccu",
            new."PermitNo",
            new."HarvestName",
            new."ClientName",
            new."ConcessionName",
            new."TransportComp",
            new."LicensePlate",
            new."Destination",
            new."ManagementUnit",
            new."OperationalUnit",
            new."AnnualOperationalUnit",
            new."Note",
            new."TheGeom",
            new."PoductType",
            new."PermitStatus",
            new."VerifiedBy",
            new."TransportBy",
            new."GeneratedBy",
            new."ScanLat",
            new."ScanLon",
            new."ScanGpsAccu",
            new."Photos",
            new."Farmer",
            new."FirstProvince",
            new."MobileId",
            new."CreatedAt",
            new."UpdatedAt",
            new."DeletedAt")

    RETURNING "Transportation"."PermitsTable"."Id" , "Transportation"."PermitsTable"."Recdate" , "Transportation"."PermitsTable"."Obsdate" , "Transportation"."PermitsTable"."Appuser" , "Transportation"."PermitsTable"."Lat" , "Transportation"."PermitsTable"."Lon" , "Transportation"."PermitsTable"."GpsAccu" , "Transportation"."PermitsTable"."PermitNo" , "Transportation"."PermitsTable"."HarvestName" , "Transportation"."PermitsTable"."ClientName" , "Transportation"."PermitsTable"."ConcessionName", "Transportation"."PermitsTable"."TransportComp" , "Transportation"."PermitsTable"."LicensePlate" , "Transportation"."PermitsTable"."Destination" , "Transportation"."PermitsTable"."ManagementUnit", "Transportation"."PermitsTable"."OperationalUnit" , "Transportation"."PermitsTable"."AnnualOperationalUnit" , "Transportation"."PermitsTable"."Note" , "Transportation"."PermitsTable"."TheGeom" , "Transportation"."PermitsTable"."PoductType" , "Transportation"."PermitsTable"."PermitStatus" , "Transportation"."PermitsTable"."VerifiedBy" , "Transportation"."PermitsTable"."TransportBy" , "Transportation"."PermitsTable"."GeneratedBy" , "Transportation"."PermitsTable"."ScanLat" , "Transportation"."PermitsTable"."ScanLon" , "Transportation"."PermitsTable"."ScanGpsAccu" , "Transportation"."PermitsTable"."Photos", "Transportation"."PermitsTable"."Farmer", "Transportation"."PermitsTable"."FirstProvince", "Transportation"."PermitsTable"."MobileId" , "Transportation"."PermitsTable"."CreatedAt", "Transportation"."PermitsTable"."UpdatedAt", "Transportation"."PermitsTable"."DeletedAt";



CREATE RULE "Permits_instead_of_update" AS
    ON UPDATE TO "Transportation"."Permits" DO INSTEAD UPDATE "Transportation"."PermitsTable"

                                                       SET "Recdate"               = new."Recdate",
                                                           "Obsdate"               = new."Obsdate",
                                                           "Appuser"               = new."Appuser",
                                                           "Lat"                   = new."Lat",
                                                           "Lon"                   = new."Lon",
                                                           "GpsAccu"               = new."GpsAccu",
                                                           "PermitNo"              = new."PermitNo",
                                                           "HarvestName"           = new."HarvestName",
                                                           "ClientName"            = new."ClientName",
                                                           "ConcessionName"        = new."ConcessionName",
                                                           "TransportComp"         = new."TransportComp",
                                                           "LicensePlate"          = new."LicensePlate",
                                                           "Destination"           = new."Destination",
                                                           "ManagementUnit"        = new."ManagementUnit",
                                                           "OperationalUnit"       = new."OperationalUnit",
                                                           "AnnualOperationalUnit" = new."AnnualOperationalUnit",
                                                           "Note"                  = new."Note",
                                                           "TheGeom"               = new."TheGeom",
                                                           "PoductType"            = new."PoductType",
                                                           "PermitStatus"          = new."PermitStatus",
                                                           "VerifiedBy"            = new."VerifiedBy",
                                                           "TransportBy"           = new."TransportBy",
                                                           "GeneratedBy"           = new."GeneratedBy",
                                                           "ScanLat"               = new."ScanLat",
                                                           "ScanLon"               = new."ScanLon",
                                                           "ScanGpsAccu"           = new."ScanGpsAccu",
                                                           "Photos"                = new."Photos",
                                                           "Farmer"                = new."Farmer",
                                                           "FirstProvince"         = new."FirstProvince",
                                                           "MobileId"              = new."MobileId",
                                                           "CreatedAt"             = new."CreatedAt",
                                                           "UpdatedAt"             = new."UpdatedAt",
                                                           "DeletedAt"             = new."DeletedAt"


                                                       WHERE ("Transportation"."PermitsTable"."Id" = old."Id")
                                                       RETURNING "Transportation"."PermitsTable"."Id" , "Transportation"."PermitsTable"."Recdate" , "Transportation"."PermitsTable"."Obsdate" , "Transportation"."PermitsTable"."Appuser" , "Transportation"."PermitsTable"."Lat" , "Transportation"."PermitsTable"."Lon" , "Transportation"."PermitsTable"."GpsAccu" , "Transportation"."PermitsTable"."PermitNo" , "Transportation"."PermitsTable"."HarvestName" , "Transportation"."PermitsTable"."ClientName" , "Transportation"."PermitsTable"."ConcessionName", "Transportation"."PermitsTable"."TransportComp" , "Transportation"."PermitsTable"."LicensePlate" , "Transportation"."PermitsTable"."Destination" , "Transportation"."PermitsTable"."ManagementUnit", "Transportation"."PermitsTable"."OperationalUnit" , "Transportation"."PermitsTable"."AnnualOperationalUnit" , "Transportation"."PermitsTable"."Note" , "Transportation"."PermitsTable"."TheGeom" , "Transportation"."PermitsTable"."PoductType" , "Transportation"."PermitsTable"."PermitStatus" , "Transportation"."PermitsTable"."VerifiedBy" , "Transportation"."PermitsTable"."TransportBy" , "Transportation"."PermitsTable"."GeneratedBy" , "Transportation"."PermitsTable"."ScanLat" , "Transportation"."PermitsTable"."ScanLon" , "Transportation"."PermitsTable"."ScanGpsAccu" , "Transportation"."PermitsTable"."Photos", "Transportation"."PermitsTable"."Farmer", "Transportation"."PermitsTable"."FirstProvince", "Transportation"."PermitsTable"."MobileId" , "Transportation"."PermitsTable"."CreatedAt", "Transportation"."PermitsTable"."UpdatedAt", "Transportation"."PermitsTable"."DeletedAt";


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
       peri."TrunkNumber",
       peri."LotNumber",
       peri."Species",
       peri."Diam1",
       peri."Diam2",
       peri."DiamAvg",
       peri."Length",
       peri."Volume",
       peri."Width",
       peri."Height",
       peri."MobileId",
       peri."Appuser",
       peri."CreatedAt",
       peri."UpdatedAt",
       peri."DeletedAt"
from "Transportation"."PermitItemsTable" as peri
;


--
-- Rules
--
create or replace rule "PermitItems_instead_of_delete"
    as
    on delete to "Transportation"."PermitItems"
    do instead
    delete
    from "Transportation"."PermitItemsTable"
    where "Transportation"."PermitItemsTable"."Id" = old."Id"
;

create or replace rule "PermitItems_instead_of_insert"
    as
    on insert to "Transportation"."PermitItems"
    do instead
    insert into "Transportation"."PermitItemsTable"
    ("Id",
     "Permit",
     "TrunkNumber",
     "LotNumber",
     "Species",
     "Diam1",
     "Diam2",
     "DiamAvg",
     "Length",
     "Volume",
     "Width",
     "Height",
     "MobileId",
     "Appuser",
     "CreatedAt",
     "UpdatedAt",
     "DeletedAt")
    values (nextval('"Transportation"."SEQ_PermitItemsTable"'),
            new."Permit",
            new."TrunkNumber",
            new."LotNumber",
            new."Species",
            new."Diam1",
            new."Diam2",
            new."DiamAvg",
            new."Length",
            new."Volume",
            new."Width",
            new."Height",
            new."MobileId",
            new."Appuser",
            new."CreatedAt",
            new."UpdatedAt",
            new."DeletedAt")
    returning "Id" , "Permit" , "TrunkNumber" , "LotNumber" , "Species" , "Diam1" , "Diam2" , "DiamAvg" , "Length" , "Volume" , "Width" , "Height" , "MobileId" , "Appuser" , "CreatedAt" , "UpdatedAt" , "DeletedAt"
;

create or replace rule "PermitItems_instead_of_update"
    as
    on update to "Transportation"."PermitItems"
    do instead
    update "Transportation"."PermitItemsTable"
    set "Permit"      = new."Permit",
        "TrunkNumber" = new."TrunkNumber",
        "LotNumber"   = new."LotNumber",
        "Species"     = new."Species",
        "Diam1"       = new."Diam1",
        "Diam2"       = new."Diam2",
        "DiamAvg"     = new."DiamAvg",
        "Length"      = new."Length",
        "Volume"      = new."Volume",
        "Width"       = new."Width",
        "Height"      = new."Height",
        "MobileId"    = new."MobileId",
        "Appuser"= new."Appuser",
        "UpdatedAt"   = new."UpdatedAt",
        "DeletedAt"   = new."DeletedAt"
    where old."Id" = new."Id"
    returning "Id" , "Permit" , "TrunkNumber" , "LotNumber" , "Species" , "Diam1" , "Diam2" , "DiamAvg" , "Length" , "Volume" , "Width" , "Height" , "MobileId" , "Appuser" , "CreatedAt" , "UpdatedAt" , "DeletedAt"
;
