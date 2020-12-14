drop view if exists "ForestResources"."AnnualAllowableCutInventory";
create or replace view "ForestResources"."AnnualAllowableCutInventory"
            ("Id", "AnnualAllowableCut", "AnnualAllowableCutName", "Species", "SpeciesCommonName", "Quality", "Parcel", "ParcelName", "TreeId",
             "DiameterBreastHeight", "Geometry", "Lat", "Lon", "GpsAccu", "User", "Email", "Approved", "MobileId",
             "ObserveAt", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT aacit."Id",
       aacit."AnnualAllowableCut",
       aac."Name" AS "AnnualAllowableCutName",
       aacit."Species",
       s."CommonName" as "SpeciesCommonName",
       aacit."Quality",
       aacit."Parcel",
       p."Name" as "ParcelName",
       aacit."TreeId",
       aacit."DiameterBreastHeight",
       aacit."Geometry",
       aacit."Lat",
       aacit."Lon",
       aacit."GpsAccu",
       aacit."User",
       acc.email  AS "Email",
       aacit."Approved",
       aacit."MobileId",
       aacit."ObserveAt",
       aacit."CreatedAt",
       aacit."UpdatedAt",
       aacit."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutInventoryTable" aacit
         LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = aacit."AnnualAllowableCut"
         LEFT JOIN "Taxonomy"."SpeciesTable" s on s."Id" = aacit."Species"
         LEFT JOIN "ForestResources"."ParcelsTable" p on aacit."Parcel" = p."Id"
         LEFT JOIN admin.accounts acc ON acc.id = aacit."User";

CREATE RULE "AnnualAllowableCutInventory_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCutInventory"
    DO INSTEAD DELETE
               FROM "ForestResources"."AnnualAllowableCutInventoryTable"
               WHERE "AnnualAllowableCutInventoryTable"."Id" = old."Id";

CREATE RULE "AnnualAllowableCutInventory_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCutInventory"
    DO INSTEAD INSERT INTO "ForestResources"."AnnualAllowableCutInventoryTable" ("Id",
                                                                                 "AnnualAllowableCut",
                                                                                 "Species",
                                                                                 "Quality",
                                                                                 "Parcel",
                                                                                 "TreeId",
                                                                                 "DiameterBreastHeight",
                                                                                 "Geometry",
                                                                                 "Lat",
                                                                                 "Lon",
                                                                                 "GpsAccu",
                                                                                 "User",
                                                                                 "Approved",
                                                                                 "MobileId",
                                                                                 "ObserveAt",
                                                                                 "CreatedAt",
                                                                                 "UpdatedAt")
               VALUES (nextval(
                               '"ForestResources"."SEQ_AnnualAllowableCutInventory"'::regclass),
                       new."AnnualAllowableCut",
                       new."Species", new."Quality",
                       new."Parcel", new."TreeId",
                       new."DiameterBreastHeight",
                       new."Geometry", new."Lat",
                       new."Lon", new."GpsAccu",
                       new."User", new."Approved",
                       new."MobileId", new."ObserveAt",
                       new."CreatedAt", new."UpdatedAt")
               RETURNING "AnnualAllowableCutInventoryTable"."Id",
                   "AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
                   (SELECT aac."Name"
                    FROM "ForestResources"."AnnualAllowableCutsTable" aac
                    WHERE "AnnualAllowableCutInventoryTable"."AnnualAllowableCut" = aac."Id"
                    LIMIT 1) AS annualallowablecutname,
                   "AnnualAllowableCutInventoryTable"."Species",
                   (SELECT s."CommonName"
                    FROM "Taxonomy"."SpeciesTable" s
                    WHERE "AnnualAllowableCutInventoryTable"."Species" = s."Id"
                    LIMIT 1) as "SpeciesCommonName",
                   "AnnualAllowableCutInventoryTable"."Quality",
                   "AnnualAllowableCutInventoryTable"."Parcel",
                   (SELECT p."Name"
                    FROM "ForestResources"."ParcelsTable" p
                    WHERE "AnnualAllowableCutInventoryTable"."Parcel" = p."Id"
                    LIMIT 1) as "ParcelName",
                   "AnnualAllowableCutInventoryTable"."TreeId",
                   "AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
                   "AnnualAllowableCutInventoryTable"."Geometry",
                   "AnnualAllowableCutInventoryTable"."Lat",
                   "AnnualAllowableCutInventoryTable"."Lon",
                   "AnnualAllowableCutInventoryTable"."GpsAccu",
                   "AnnualAllowableCutInventoryTable"."User",
                   (SELECT acc.email
                    FROM admin.accounts acc
                    WHERE "AnnualAllowableCutInventoryTable"."User" = acc.id
                    LIMIT 1) AS "Email",
                   "AnnualAllowableCutInventoryTable"."Approved",
                   "AnnualAllowableCutInventoryTable"."MobileId",
                   "AnnualAllowableCutInventoryTable"."ObserveAt",
                   "AnnualAllowableCutInventoryTable"."CreatedAt",
                   "AnnualAllowableCutInventoryTable"."UpdatedAt",
                   "AnnualAllowableCutInventoryTable"."DeletedAt";

CREATE RULE "AnnualAllowableCutInventory_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD UPDATE "ForestResources"."AnnualAllowableCutInventoryTable"
                                                                            SET "AnnualAllowableCut"   = new."AnnualAllowableCut",
                                                                                "Species"              = new."Species",
                                                                                "Quality"              = new."Quality",
                                                                                "Parcel"               = new."Parcel",
                                                                                "TreeId"               = new."TreeId",
                                                                                "DiameterBreastHeight" = new."DiameterBreastHeight",
                                                                                "Geometry"             = new."Geometry",
                                                                                "Lat"                  = new."Lat",
                                                                                "Lon"                  = new."Lon",
                                                                                "GpsAccu"              = new."GpsAccu",
                                                                                "User"                 = new."User",
                                                                                "Approved"             = new."Approved",
                                                                                "MobileId"             = new."MobileId",
                                                                                "ObserveAt"            = new."ObserveAt",
                                                                                "UpdatedAt"            = new."UpdatedAt",
                                                                                "DeletedAt"            = new."DeletedAt"
                                                                            WHERE "AnnualAllowableCutInventoryTable"."Id" = old."Id"
                                                                            RETURNING "AnnualAllowableCutInventoryTable"."Id",
                                                                                "AnnualAllowableCutInventoryTable"."AnnualAllowableCut",
                                                                                (SELECT aac."Name"
                                                                                 FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                                 WHERE "AnnualAllowableCutInventoryTable"."AnnualAllowableCut" = aac."Id"
                                                                                 LIMIT 1) AS annualallowablecutname,
                                                                                "AnnualAllowableCutInventoryTable"."Species",
                                                                                (SELECT s."CommonName"
                                                                                 FROM "Taxonomy"."SpeciesTable" s
                                                                                 WHERE "AnnualAllowableCutInventoryTable"."Species" = s."Id"
                                                                                 LIMIT 1) as "SpeciesCommonName",
                                                                                "AnnualAllowableCutInventoryTable"."Quality",
                                                                                "AnnualAllowableCutInventoryTable"."Parcel",
                                                                                (SELECT p."Name"
                                                                                 FROM "ForestResources"."ParcelsTable" p
                                                                                 WHERE "AnnualAllowableCutInventoryTable"."Parcel" = p."Id"
                                                                                 LIMIT 1) as "ParcelName",
                                                                                "AnnualAllowableCutInventoryTable"."TreeId",
                                                                                "AnnualAllowableCutInventoryTable"."DiameterBreastHeight",
                                                                                "AnnualAllowableCutInventoryTable"."Geometry",
                                                                                "AnnualAllowableCutInventoryTable"."Lat",
                                                                                "AnnualAllowableCutInventoryTable"."Lon",
                                                                                "AnnualAllowableCutInventoryTable"."GpsAccu",
                                                                                "AnnualAllowableCutInventoryTable"."User",
                                                                                (SELECT acc.email
                                                                                 FROM admin.accounts acc
                                                                                 WHERE "AnnualAllowableCutInventoryTable"."User" = acc.id
                                                                                 LIMIT 1) AS "Email",
                                                                                "AnnualAllowableCutInventoryTable"."Approved",
                                                                                "AnnualAllowableCutInventoryTable"."MobileId",
                                                                                "AnnualAllowableCutInventoryTable"."ObserveAt",
                                                                                "AnnualAllowableCutInventoryTable"."CreatedAt",
                                                                                "AnnualAllowableCutInventoryTable"."UpdatedAt",
                                                                                "AnnualAllowableCutInventoryTable"."DeletedAt";
