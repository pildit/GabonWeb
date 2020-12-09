alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add "User" int;

alter table "ForestResources"."AnnualAllowableCutInventoryTable"
    add constraint annualallowablecutinventorytable_accounts_id_fk
        foreign key ("User") references admin.accounts;


alter table "ForestResources"."AnnualAllowableCutsTable"
    add "User" int;

alter table "ForestResources"."AnnualAllowableCutsTable"
    add constraint annualallowablecutstable_accounts_id_fk
        foreign key ("User") references admin.accounts;



drop view if exists "ForestResources"."DevelopmentUnits";
create view "ForestResources"."DevelopmentUnits"
            ("Id", "Name", "Concession","ConcessionName", "Start", "End", "Geometry", "Approved", "Number", "User", "Email",
             "ProductType", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT ct."Id",
       ct."Name",
       ct."Concession",
       con."Name" AS "ConcessionName",
       ct."Start",
       ct."End",
       ct."Geometry",
       ct."Approved",
       ct."Number",
       ct."User",
       acc.email AS "Email",
       ct."ProductType",
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."DevelopmentUnitsTable" ct
         LEFT JOIN admin.accounts acc ON ct."User" = acc.id
         LEFT JOIN "ForestResources"."ConcessionsTable" con ON ct."Concession" = con."Id";


CREATE RULE "DevelopmentUnits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."DevelopmentUnits" DO INSTEAD DELETE
                                                                 FROM "ForestResources"."DevelopmentUnitsTable"
                                                                 WHERE "DevelopmentUnitsTable"."Id" = old."Id";

CREATE RULE "DevelopmentUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentUnits" DO INSTEAD INSERT INTO "ForestResources"."DevelopmentUnitsTable" ("Id",
                                                                                                                        "ResourceType",
                                                                                                                        "Name",
                                                                                                                        "Concession",
                                                                                                                        "Start",
                                                                                                                        "End",
                                                                                                                        "Geometry",
                                                                                                                        "Approved",
                                                                                                                        "Number",
                                                                                                                        "User",
                                                                                                                        "ProductType",
                                                                                                                        "CreatedAt",
                                                                                                                        "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                         (SELECT rt."Id"
                                                                          FROM "ForestResources"."ResourceTypes" rt
                                                                          WHERE rt."Name" = 'Development Unit'::text
                                                                          LIMIT 1), new."Name", new."Concession",
                                                                         new."Start", new."End", new."Geometry",
                                                                         new."Approved", new."Number", new."User",
                                                                         new."ProductType", new."CreatedAt",
                                                                         new."UpdatedAt")
                                                                 RETURNING "DevelopmentUnitsTable"."Id", "DevelopmentUnitsTable"."Name", "DevelopmentUnitsTable"."Concession",
                                                                  (SELECT con."Name"
                                                                  FROM "ForestResources"."ConcessionsTable" con
                                                                  WHERE "DevelopmentUnitsTable"."Concession" = con."Id"
                                                                  LIMIT 1) AS ConcessionName,
                                                                  "DevelopmentUnitsTable"."Start", "DevelopmentUnitsTable"."End", "DevelopmentUnitsTable"."Geometry", "DevelopmentUnitsTable"."Approved", "DevelopmentUnitsTable"."Number", "DevelopmentUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                          FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                          WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                          LIMIT 1) AS email,

                                                                                                                                                                                                                                                                                                                                                                                          "DevelopmentUnitsTable"."ProductType", "DevelopmentUnitsTable"."CreatedAt", "DevelopmentUnitsTable"."UpdatedAt", "DevelopmentUnitsTable"."DeletedAt";

CREATE RULE "DevelopmentUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentUnits" DO INSTEAD UPDATE "ForestResources"."DevelopmentUnitsTable"
                                                                 SET "Name"        = new."Name",
                                                                     "Concession"  = new."Concession",
                                                                     "Start"       = new."Start",
                                                                     "End"         = new."End",
                                                                     "Geometry"    = new."Geometry",
                                                                     "Approved"    = new."Approved",
                                                                     "Number"      = new."Number",
                                                                     "User"        = new."User",
                                                                     "ProductType" = new."ProductType",
                                                                     "UpdatedAt"   = new."UpdatedAt",
                                                                     "DeletedAt"   = new."DeletedAt"
                                                                 WHERE "DevelopmentUnitsTable"."Id" = old."Id"
                                                                 RETURNING "DevelopmentUnitsTable"."Id", "DevelopmentUnitsTable"."Name", "DevelopmentUnitsTable"."Concession",
                                                                  (SELECT con."Name"
                                                                  FROM "ForestResources"."ConcessionsTable" con
                                                                  WHERE "DevelopmentUnitsTable"."Concession" = con."Id"
                                                                  LIMIT 1) AS ConcessionName,
                                                                  "DevelopmentUnitsTable"."Start", "DevelopmentUnitsTable"."End", "DevelopmentUnitsTable"."Geometry", "DevelopmentUnitsTable"."Approved", "DevelopmentUnitsTable"."Number", "DevelopmentUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                          FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                          WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                          LIMIT 1) AS email,

                                                                                                                                                                                                                                                                                                                                                                                          "DevelopmentUnitsTable"."ProductType", "DevelopmentUnitsTable"."CreatedAt", "DevelopmentUnitsTable"."UpdatedAt", "DevelopmentUnitsTable"."DeletedAt";




drop view if exists "ForestResources"."ManagementUnits";
create view "ForestResources"."ManagementUnits"
            ("Id", "Name", "DevelopmentUnit", "DevelopmentUnitName","Geometry", "Approved", "Number", "User", "Email", "ProductType",
             "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT mut."Id",
       mut."Name",
       mut."DevelopmentUnit",
       du."Name" as "DevelopmentUnitName",
       mut."Geometry",
       mut."Approved",
       mut."Number",
       mut."User",
       acc.email AS "Email",
       mut."ProductType",
       mut."CreatedAt",
       mut."UpdatedAt",
       mut."DeletedAt"
FROM "ForestResources"."ManagementUnitsTable" mut
         LEFT JOIN admin.accounts acc ON acc.id = mut."User"
        LEFT JOIN "ForestResources"."DevelopmentUnitsTable" du ON du."Id" = mut."DevelopmentUnit";


CREATE RULE "ManagementUnits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ManagementUnits" DO INSTEAD DELETE
                                                                FROM "ForestResources"."ManagementUnitsTable"
                                                                WHERE "ManagementUnitsTable"."Id" = old."Id";

CREATE RULE "ManagementUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementUnits" DO INSTEAD INSERT INTO "ForestResources"."ManagementUnitsTable" ("Id",
                                                                                                                      "ResourceType",
                                                                                                                      "Name",
                                                                                                                      "DevelopmentUnit",
                                                                                                                      "Geometry",
                                                                                                                      "Approved",
                                                                                                                      "Number",
                                                                                                                      "User",
                                                                                                                      "ProductType",
                                                                                                                      "CreatedAt",
                                                                                                                      "UpdatedAt")
                                                                VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                        (SELECT rt."Id"
                                                                         FROM "ForestResources"."ResourceTypes" rt
                                                                         WHERE rt."Name" = 'Management Unit'::text
                                                                         LIMIT 1), new."Name", new."DevelopmentUnit",
                                                                        new."Geometry", new."Approved", new."Number",
                                                                        new."User", new."ProductType", new."CreatedAt",
                                                                        new."UpdatedAt")
                                                                RETURNING "ManagementUnitsTable"."Id", "ManagementUnitsTable"."Name", "ManagementUnitsTable"."DevelopmentUnit",
                                                                (SELECT du."Name"
                                                               FROM "ForestResources"."DevelopmentUnitsTable" du
                                                               WHERE "ManagementUnitsTable"."DevelopmentUnit" = du."Id"
                                                               LIMIT 1) AS DevelopmentUnitName,
                                                                "ManagementUnitsTable"."Geometry", "ManagementUnitsTable"."Approved", "ManagementUnitsTable"."Number", "ManagementUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                       FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                       WHERE "ManagementUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS email, "ManagementUnitsTable"."ProductType", "ManagementUnitsTable"."CreatedAt", "ManagementUnitsTable"."UpdatedAt", "ManagementUnitsTable"."DeletedAt";

CREATE RULE "ManagementUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ManagementUnits" DO INSTEAD UPDATE "ForestResources"."ManagementUnitsTable"
                                                                SET "Name"            = new."Name",
                                                                    "DevelopmentUnit" = new."DevelopmentUnit",
                                                                    "Geometry"        = new."Geometry",
                                                                    "Approved"        = new."Approved",
                                                                    "Number"          = new."Number",
                                                                    "User"            = new."User",
                                                                    "ProductType"     = new."ProductType",
                                                                    "UpdatedAt"       = new."UpdatedAt",
                                                                    "DeletedAt"       = new."DeletedAt"
                                                                WHERE "ManagementUnitsTable"."Id" = old."Id"
                                                                 RETURNING "ManagementUnitsTable"."Id", "ManagementUnitsTable"."Name", "ManagementUnitsTable"."DevelopmentUnit",
                                                                (SELECT du."Name"
                                                               FROM "ForestResources"."DevelopmentUnitsTable" du
                                                               WHERE "ManagementUnitsTable"."DevelopmentUnit" = du."Id"
                                                               LIMIT 1) AS DevelopmentUnitName,
                                                                "ManagementUnitsTable"."Geometry", "ManagementUnitsTable"."Approved", "ManagementUnitsTable"."Number", "ManagementUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                       FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                       WHERE "ManagementUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS email, "ManagementUnitsTable"."ProductType", "ManagementUnitsTable"."CreatedAt", "ManagementUnitsTable"."UpdatedAt", "ManagementUnitsTable"."DeletedAt";
drop view if exists "ForestResources"."Parcels";
create view "ForestResources"."Parcels"
            ("Id", "Name", "Geometry", "Approved", "User","Email", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT pt."Id",
       pt."Name",
       pt."Geometry",
       pt."Approved",
       pt."User",
       acc.email AS "Email",
       pt."CreatedAt",
       pt."UpdatedAt",
       pt."DeletedAt"
FROM "ForestResources"."ParcelsTable" pt
LEFT JOIN admin.accounts acc ON acc.id = pt."User";

CREATE RULE "Parcels_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Parcels" DO INSTEAD DELETE
                                                        FROM "ForestResources"."ParcelsTable"
                                                        WHERE "ParcelsTable"."Id" = old."Id";

CREATE RULE "Parcels_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Parcels" DO INSTEAD INSERT INTO "ForestResources"."ParcelsTable" ("Id",
                                                                                                      "ResourceType",
                                                                                                      "Name",
                                                                                                      "Geometry",
                                                                                                      "CreatedAt",
                                                                                                      "Approved",
                                                                                                      "User")
                                                        VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                (SELECT rt."Id"
                                                                 FROM "ForestResources"."ResourceTypes" rt
                                                                 WHERE rt."Name" = 'Parcel'::text
                                                                 LIMIT 1), new."Name", new."Geometry", new."CreatedAt",
                                                                new."Approved", new."User")
                                                        RETURNING "ParcelsTable"."Id", "ParcelsTable"."Name", "ParcelsTable"."Geometry", "ParcelsTable"."Approved", "ParcelsTable"."User",(SELECT acc.email
                                                                                                                                                                                                                                                                                                                       FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                       WHERE "ParcelsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS email, "ParcelsTable"."CreatedAt", "ParcelsTable"."UpdatedAt", "ParcelsTable"."DeletedAt";

CREATE RULE "Parcels_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Parcels" DO INSTEAD UPDATE "ForestResources"."ParcelsTable"
                                                        SET "Name"      = new."Name",
                                                            "Geometry"  = new."Geometry",
                                                            "Approved"  = new."Approved",
                                                            "UpdatedAt" = new."UpdatedAt",
                                                            "DeletedAt" = new."DeletedAt"
                                                        WHERE "ParcelsTable"."Id" = old."Id"
                                                        RETURNING "ParcelsTable"."Id", "ParcelsTable"."Name", "ParcelsTable"."Geometry", "ParcelsTable"."Approved", "ParcelsTable"."User",(SELECT acc.email
                                                                                                                                                                                                                                                                                                                       FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                       WHERE "ParcelsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS email, "ParcelsTable"."CreatedAt", "ParcelsTable"."UpdatedAt", "ParcelsTable"."DeletedAt";
drop view if exists "ForestResources"."AnnualAllowableCuts";
create view "ForestResources"."AnnualAllowableCuts"
            ("Id", "Name", "AacId", "ManagementUnit", "ManagementUnitName","ManagementPlan", "Geometry", "ProductType", "User","Email","Approved",
             "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT mut."Id",
       mut."Name",
       mut."AacId",
       mut."ManagementUnit",
        mu."Name" AS "ManagementUnitName",
       mut."ManagementPlan",
       mut."Geometry",
       mut."ProductType",
       mut."User",
       acc.email AS "Email",
       mut."Approved",
       mut."CreatedAt",
       mut."UpdatedAt",
       mut."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutsTable" mut
 LEFT JOIN "ForestResources"."ManagementUnitsTable" mu ON mu."Id" = mut."ManagementUnit"
LEFT JOIN admin.accounts acc ON acc.id = mut."User";

CREATE RULE "AnnualAllowableCuts_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD DELETE
                                                                    FROM "ForestResources"."AnnualAllowableCutsTable"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id";

CREATE RULE "AnnualAllowableCuts_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD INSERT INTO "ForestResources"."AnnualAllowableCutsTable" ("Id",
                                                                                                                              "ResourceType",
                                                                                                                              "Name",
                                                                                                                              "AacId",
                                                                                                                              "ManagementUnit",
                                                                                                                              "ManagementPlan",
                                                                                                                              "Geometry",
                                                                                                                              "ProductType",
                                                                                                                              "User",
                                                                                                                              "Approved",
                                                                                                                              "CreatedAt",
                                                                                                                              "UpdatedAt")
                                                                    VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                            (SELECT rt."Id"
                                                                             FROM "ForestResources"."ResourceTypes" rt
                                                                             WHERE rt."Name" = 'Annual Allowable Cut'::text
                                                                             LIMIT 1), new."Name", new."AacId",
                                                                            new."ManagementUnit", new."ManagementPlan",
                                                                            new."Geometry", new."ProductType", new."User",
                                                                            new."Approved", new."CreatedAt",
                                                                            new."UpdatedAt")
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit",

                                                                     (SELECT mu."Name"
                                                                   FROM "ForestResources"."ManagementUnitsTable" mu
                                                                   WHERE "AnnualAllowableCutsTable"."ManagementUnit" = mu."Id"
                                                                   LIMIT 1) AS ManagementUnitName,

                                                                     "AnnualAllowableCutsTable"."ManagementPlan", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", "AnnualAllowableCutsTable"."User",

                                                                        (SELECT acc.email
                                                                         FROM admin.accounts acc
                                                                         WHERE "AnnualAllowableCutsTable"."User" = acc.id
                                                                         LIMIT 1) AS email,

                                                                        "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";

CREATE RULE "AnnualAllowableCuts_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD UPDATE "ForestResources"."AnnualAllowableCutsTable"
                                                                    SET "Name"           = new."Name",
                                                                        "AacId"          = new."AacId",
                                                                        "ManagementUnit" = new."ManagementUnit",
                                                                        "ManagementPlan" = new."ManagementPlan",
                                                                        "Geometry"       = new."Geometry",
                                                                        "ProductType"    = new."ProductType",
                                                                        "User"    = new."User",
                                                                        "Approved"       = new."Approved",
                                                                        "UpdatedAt"      = new."UpdatedAt",
                                                                        "DeletedAt"      = new."DeletedAt"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id"
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit",

                                                                     (SELECT mu."Name"
                                                                   FROM "ForestResources"."ManagementUnitsTable" mu
                                                                   WHERE "AnnualAllowableCutsTable"."ManagementUnit" = mu."Id"
                                                                   LIMIT 1) AS ManagementUnitName,

                                                                     "AnnualAllowableCutsTable"."ManagementPlan", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", "AnnualAllowableCutsTable"."User",
                                                                        (SELECT acc.email
                                                                         FROM admin.accounts acc
                                                                         WHERE "AnnualAllowableCutsTable"."User" = acc.id
                                                                         LIMIT 1) AS email,
                                                                        "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";



drop view if exists "ForestResources"."AnnualAllowableCutInventory";

create view "ForestResources"."AnnualAllowableCutInventory"
            ("Id", "AnnualAllowableCut","AnnualAllowableCutName", "Species", "Quality", "Parcel", "TreeId", "DiameterBreastHeight", "Geometry",
             "Lat", "Lon", "GpsAccu", "User","Email", "Approved", "MobileId", "ObserveAt", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT aacit."Id",
       aacit."AnnualAllowableCut",
       aac."Name" AS "AnnualAllowableCutName",
       aacit."Species",
       aacit."Quality",
       aacit."Parcel",
       aacit."TreeId",
       aacit."DiameterBreastHeight",
       aacit."Geometry",
       aacit."Lat",
       aacit."Lon",
       aacit."GpsAccu",
       aacit."User",
       acc.email AS "Email",
       aacit."Approved",
       aacit."MobileId",
       aacit."ObserveAt",
       aacit."CreatedAt",
       aacit."UpdatedAt",
       aacit."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutInventoryTable" aacit
LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = aacit."AnnualAllowableCut"
LEFT JOIN admin.accounts acc ON acc.id = aacit."User";

CREATE RULE "AnnualAllowableCutInventory_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD DELETE
                                                                            FROM "ForestResources"."AnnualAllowableCutInventoryTable"
                                                                            WHERE "AnnualAllowableCutInventoryTable"."Id" = old."Id";

CREATE RULE "AnnualAllowableCutInventory_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCutInventory" DO INSTEAD INSERT INTO "ForestResources"."AnnualAllowableCutInventoryTable" ("Id",
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
                                                                                    new."Lon", new."GpsAccu", new."User",
                                                                                    new."Approved", new."MobileId",
                                                                                    new."ObserveAt", new."CreatedAt",
                                                                                    new."UpdatedAt")
                                                                            RETURNING "AnnualAllowableCutInventoryTable"."Id", "AnnualAllowableCutInventoryTable"."AnnualAllowableCut",

                                                                              (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,

                                                                             "AnnualAllowableCutInventoryTable"."Species", "AnnualAllowableCutInventoryTable"."Quality", "AnnualAllowableCutInventoryTable"."Parcel", "AnnualAllowableCutInventoryTable"."TreeId", "AnnualAllowableCutInventoryTable"."DiameterBreastHeight", "AnnualAllowableCutInventoryTable"."Geometry", "AnnualAllowableCutInventoryTable"."Lat", "AnnualAllowableCutInventoryTable"."Lon", "AnnualAllowableCutInventoryTable"."GpsAccu", "AnnualAllowableCutInventoryTable"."User",

                                                                                (SELECT acc.email
                                                                                 FROM admin.accounts acc
                                                                                 WHERE "AnnualAllowableCutInventoryTable"."User" = acc.id
                                                                                 LIMIT 1) AS email,

                                                                                "AnnualAllowableCutInventoryTable"."Approved", "AnnualAllowableCutInventoryTable"."MobileId", "AnnualAllowableCutInventoryTable"."ObserveAt", "AnnualAllowableCutInventoryTable"."CreatedAt", "AnnualAllowableCutInventoryTable"."UpdatedAt", "AnnualAllowableCutInventoryTable"."DeletedAt";

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
                                                                                "User"                  = new."User",
                                                                                "Approved"             = new."Approved",
                                                                                "MobileId"             = new."MobileId",
                                                                                "ObserveAt"            = new."ObserveAt",
                                                                                "UpdatedAt"            = new."UpdatedAt",
                                                                                "DeletedAt"            = new."DeletedAt"
                                                                            WHERE "AnnualAllowableCutInventoryTable"."Id" = old."Id"
                                                                            RETURNING "AnnualAllowableCutInventoryTable"."Id", "AnnualAllowableCutInventoryTable"."AnnualAllowableCut",

                                                                               (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                                WHERE "ForestResources"."AnnualAllowableCutInventoryTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,

                                                                             "AnnualAllowableCutInventoryTable"."Species", "AnnualAllowableCutInventoryTable"."Quality", "AnnualAllowableCutInventoryTable"."Parcel", "AnnualAllowableCutInventoryTable"."TreeId", "AnnualAllowableCutInventoryTable"."DiameterBreastHeight", "AnnualAllowableCutInventoryTable"."Geometry", "AnnualAllowableCutInventoryTable"."Lat", "AnnualAllowableCutInventoryTable"."Lon", "AnnualAllowableCutInventoryTable"."GpsAccu", "AnnualAllowableCutInventoryTable"."User",

                                                                                (SELECT acc.email
                                                                                 FROM admin.accounts acc
                                                                                 WHERE "AnnualAllowableCutInventoryTable"."User" = acc.id
                                                                                 LIMIT 1) AS email,

                                                                                "AnnualAllowableCutInventoryTable"."Approved", "AnnualAllowableCutInventoryTable"."MobileId", "AnnualAllowableCutInventoryTable"."ObserveAt", "AnnualAllowableCutInventoryTable"."CreatedAt", "AnnualAllowableCutInventoryTable"."UpdatedAt", "AnnualAllowableCutInventoryTable"."DeletedAt";





drop view if exists "ForestResources"."Logbooks";
create view "ForestResources"."Logbooks"
            ("Id", "Concession","ConcessionName", "DevelopmentUnit", "ManagementUnit", "AnnualAllowableCut", "AnnualAllowableCutName", "ObserveAt", "Approved",
             "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT lb."Id",
       lb."Concession",
        con."Name" AS "ConcessionName",
       lb."DevelopmentUnit",
       lb."ManagementUnit",
       lb."AnnualAllowableCut",
       aac."Name" AS "AnnualAllowableCutName",
       lb."ObserveAt",
       lb."Approved",
       lb."MobileId",
       lb."CreatedAt",
       lb."UpdatedAt",
       lb."DeletedAt"
FROM "ForestResources"."LogbooksTable" lb
  LEFT JOIN "ForestResources"."ConcessionsTable" con ON lb."Concession" = con."Id"
  LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = lb."AnnualAllowableCut";


CREATE RULE "Logbooks_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Logbooks" DO INSTEAD DELETE
                                                         FROM "ForestResources"."LogbooksTable"
                                                         WHERE "LogbooksTable"."Id" = old."Id";

CREATE RULE "Logbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Logbooks" DO INSTEAD INSERT INTO "ForestResources"."LogbooksTable" ("Id",
                                                                                                        "Concession",
                                                                                                        "DevelopmentUnit",
                                                                                                        "ManagementUnit",
                                                                                                        "AnnualAllowableCut",
                                                                                                        "ObserveAt",
                                                                                                        "Approved",
                                                                                                        "MobileId",
                                                                                                        "CreatedAt",
                                                                                                        "UpdatedAt")
                                                         VALUES (nextval('"ForestResources"."SEQ_LogbooksTable"'::regclass),
                                                                 new."Concession", new."DevelopmentUnit",
                                                                 new."ManagementUnit", new."AnnualAllowableCut",
                                                                 new."ObserveAt", new."Approved", new."MobileId",
                                                                 new."CreatedAt", new."UpdatedAt")
                                                         RETURNING "LogbooksTable"."Id", "LogbooksTable"."Concession",
                                                             (SELECT con."Name"
                                                                  FROM "ForestResources"."ConcessionsTable" con
                                                                  WHERE "LogbooksTable"."Concession" = con."Id"
                                                                  LIMIT 1) AS ConcessionName,

                                                         "LogbooksTable"."DevelopmentUnit", "LogbooksTable"."ManagementUnit", "LogbooksTable"."AnnualAllowableCut",

                                                          (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "LogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,

                                                         "LogbooksTable"."ObserveAt", "LogbooksTable"."Approved", "LogbooksTable"."MobileId", "LogbooksTable"."CreatedAt", "LogbooksTable"."UpdatedAt", "LogbooksTable"."DeletedAt";

CREATE RULE "Logbooks_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Logbooks" DO INSTEAD UPDATE "ForestResources"."LogbooksTable"
                                                         SET "Concession"         = new."Concession",
                                                             "DevelopmentUnit"    = new."DevelopmentUnit",
                                                             "ManagementUnit"     = new."ManagementUnit",
                                                             "AnnualAllowableCut" = new."AnnualAllowableCut",
                                                             "ObserveAt"          = new."ObserveAt",
                                                             "Approved"           = new."Approved",
                                                             "MobileId"           = new."MobileId",
                                                             "UpdatedAt"          = new."UpdatedAt",
                                                             "DeletedAt"          = new."DeletedAt"
                                                         WHERE "LogbooksTable"."Id" = old."Id"
                                                         RETURNING "LogbooksTable"."Id", "LogbooksTable"."Concession",
                                                             (SELECT con."Name"
                                                                  FROM "ForestResources"."ConcessionsTable" con
                                                                  WHERE "LogbooksTable"."Concession" = con."Id"
                                                                  LIMIT 1) AS ConcessionName,

                                                         "LogbooksTable"."DevelopmentUnit", "LogbooksTable"."ManagementUnit", "LogbooksTable"."AnnualAllowableCut",

                                                          (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "LogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,

                                                         "LogbooksTable"."ObserveAt", "LogbooksTable"."Approved", "LogbooksTable"."MobileId", "LogbooksTable"."CreatedAt", "LogbooksTable"."UpdatedAt", "LogbooksTable"."DeletedAt";



drop view if exists "ForestResources"."SiteLogbooks";
create view "ForestResources"."SiteLogbooks"
            ("Id", "AnnualAllowableCut","AnnualAllowableCutName" ,"ManagementUnit", "DevelopmentUnit", "Concession","ConcessionName", "Company","CompanyName", "Hammer",
             "Localization", "ReportNo", "ReportNote", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt",
             "DeletedAt")
as
SELECT slb."Id",
       slb."AnnualAllowableCut",
       aac."Name" AS "AnnualAllowableCutName",
       slb."ManagementUnit",
       slb."DevelopmentUnit",
       slb."Concession",
       con."Name" AS "ConcessionName",
       slb."Company",
       com."Name" AS "CompanyName",
       slb."Hammer",
       slb."Localization",
       slb."ReportNo",
       slb."ReportNote",
       slb."ObserveAt",
       slb."Approved",
       slb."MobileId",
       slb."CreatedAt",
       slb."UpdatedAt",
       slb."DeletedAt"
FROM "ForestResources"."SiteLogbooksTable" slb
 LEFT JOIN "ForestResources"."ConcessionsTable" con ON slb."Concession" = con."Id"
 LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = slb."AnnualAllowableCut"
 LEFT JOIN "Taxonomy"."CompaniesTable" com ON com."Id" = slb."Company";



CREATE RULE "SiteLogbooks_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbooks" DO INSTEAD DELETE
                                                             FROM "ForestResources"."SiteLogbooksTable"
                                                             WHERE "SiteLogbooksTable"."Id" = old."Id";

CREATE RULE "SiteLogbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."SiteLogbooks" DO INSTEAD INSERT INTO "ForestResources"."SiteLogbooksTable" ("Id",
                                                                                                                "AnnualAllowableCut",
                                                                                                                "ManagementUnit",
                                                                                                                "DevelopmentUnit",
                                                                                                                "Concession",
                                                                                                                "Company",
                                                                                                                "Hammer",
                                                                                                                "Localization",
                                                                                                                "ReportNo",
                                                                                                                "ReportNote",
                                                                                                                "ObserveAt",
                                                                                                                "Approved",
                                                                                                                "MobileId",
                                                                                                                "CreatedAt",
                                                                                                                "UpdatedAt")
                                                             VALUES (nextval('"ForestResources"."SEQ_SiteLogbooksTable"'::regclass),
                                                                     new."AnnualAllowableCut", new."ManagementUnit",
                                                                     new."DevelopmentUnit", new."Concession",
                                                                     new."Company", new."Hammer", new."Localization",
                                                                     new."ReportNo", new."ReportNote", new."ObserveAt",
                                                                     new."Approved", new."MobileId", new."CreatedAt",
                                                                     new."CreatedAt")
                                                             RETURNING "SiteLogbooksTable"."Id", "SiteLogbooksTable"."AnnualAllowableCut",

                                                                  (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "ForestResources"."SiteLogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,

                                                              "SiteLogbooksTable"."ManagementUnit", "SiteLogbooksTable"."DevelopmentUnit", "SiteLogbooksTable"."Concession",

                                                              (SELECT con."Name"
                                                                  FROM "ForestResources"."ConcessionsTable" con
                                                                  WHERE "ForestResources"."SiteLogbooksTable"."Concession" = con."Id"
                                                                  LIMIT 1) AS ConcessionName,

                                                              "SiteLogbooksTable"."Company",

                                                               (SELECT com."Name"
                                                                  FROM "Taxonomy"."CompaniesTable" com
                                                                  WHERE "ForestResources"."SiteLogbooksTable"."Company" = com."Id"
                                                                  LIMIT 1) AS CompanyName,

                                                               "SiteLogbooksTable"."Hammer", "SiteLogbooksTable"."Localization", "SiteLogbooksTable"."ReportNo", "SiteLogbooksTable"."ReportNote", "SiteLogbooksTable"."ObserveAt", "SiteLogbooksTable"."Approved", "SiteLogbooksTable"."MobileId", "SiteLogbooksTable"."CreatedAt", "SiteLogbooksTable"."UpdatedAt", "SiteLogbooksTable"."DeletedAt";

CREATE RULE "SiteLogbooks_instead_of_update" AS
    ON UPDATE TO "ForestResources"."SiteLogbooks" DO INSTEAD UPDATE "ForestResources"."SiteLogbooksTable"
                                                             SET "AnnualAllowableCut" = new."AnnualAllowableCut",
                                                                 "ManagementUnit"     = new."ManagementUnit",
                                                                 "DevelopmentUnit"    = new."DevelopmentUnit",
                                                                 "Concession"         = new."Concession",
                                                                 "Company"            = new."Company",
                                                                 "Hammer"             = new."Hammer",
                                                                 "Localization"       = new."Localization",
                                                                 "ReportNo"           = new."ReportNo",
                                                                 "ReportNote"         = new."ReportNote",
                                                                 "ObserveAt"          = new."ObserveAt",
                                                                 "Approved"           = new."Approved",
                                                                 "MobileId"           = new."MobileId",
                                                                 "CreatedAt"          = new."CreatedAt",
                                                                 "UpdatedAt"          = new."UpdatedAt",
                                                                 "DeletedAt"          = new."DeletedAt"
                                                             WHERE "SiteLogbooksTable"."Id" = old."Id"
                                                             RETURNING "SiteLogbooksTable"."Id", "SiteLogbooksTable"."AnnualAllowableCut",

                                                                  (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "ForestResources"."SiteLogbooksTable"."Company" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,

                                                              "SiteLogbooksTable"."ManagementUnit", "SiteLogbooksTable"."DevelopmentUnit", "SiteLogbooksTable"."Concession",

                                                              (SELECT con."Name"
                                                                  FROM "ForestResources"."ConcessionsTable" con
                                                                  WHERE "ForestResources"."SiteLogbooksTable"."Concession" = con."Id"
                                                                  LIMIT 1) AS ConcessionName,

                                                              "SiteLogbooksTable"."Company",

                                                               (SELECT com."Name"
                                                                  FROM "Taxonomy"."CompaniesTable" com
                                                                  WHERE "SiteLogbooksTable"."Company" = com."Id"
                                                                  LIMIT 1) AS CompanyName,

                                                               "SiteLogbooksTable"."Hammer", "SiteLogbooksTable"."Localization", "SiteLogbooksTable"."ReportNo", "SiteLogbooksTable"."ReportNote", "SiteLogbooksTable"."ObserveAt", "SiteLogbooksTable"."Approved", "SiteLogbooksTable"."MobileId", "SiteLogbooksTable"."CreatedAt", "SiteLogbooksTable"."UpdatedAt", "SiteLogbooksTable"."DeletedAt";


drop view if exists "ForestResources"."Concessions";
create view "ForestResources"."Concessions"
            ("Id", "Number", "Name", "Continent", "ConstituentPermit","ConstituentPermitNumber", "Geometry", "ProductType", "Company", "Approved",
             "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT ct."Id",
       ct."Number",
       ct."Name",
       ct."Continent",
       ct."ConstituentPermit",
       cp."PermitNumber" AS "ConstituentPermitNumber",
       ct."Geometry",
       ct."ProductType",
       ct."Company",
       ct."Approved",
       ct."User",
       acc.email AS "Email",
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."ConcessionsTable" ct
         LEFT JOIN admin.accounts acc ON ct."User" = acc.id
        LEFT JOIN "ForestResources"."ConstituentPermitsTable" cp ON ct."ConstituentPermit" = cp."Id";




CREATE RULE "Concessions_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Concessions" DO INSTEAD DELETE
                                                            FROM "ForestResources"."ConcessionsTable"
                                                            WHERE "ConcessionsTable"."Id" = old."Id";

CREATE RULE "Concessions_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Concessions" DO INSTEAD INSERT INTO "ForestResources"."ConcessionsTable" ("Id",
                                                                                                              "ResourceType",
                                                                                                              "Number",
                                                                                                              "Name",
                                                                                                              "Continent",
                                                                                                              "ConstituentPermit",
                                                                                                              "Geometry",
                                                                                                              "ProductType",
                                                                                                              "Company",
                                                                                                              "Approved",
                                                                                                              "User",
                                                                                                              "CreatedAt",
                                                                                                              "UpdatedAt")
                                                            VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                    (SELECT rt."Id"
                                                                     FROM "ForestResources"."ResourceTypes" rt
                                                                     WHERE rt."Name" = 'Concession'::text
                                                                     LIMIT 1), new."Name", new."Number",
                                                                    new."Continent", new."ConstituentPermit",
                                                                    new."Geometry", new."ProductType", new."Company",
                                                                    new."Approved", new."User", new."CreatedAt",
                                                                    new."UpdatedAt")
                                                            RETURNING "ConcessionsTable"."Id", "ConcessionsTable"."Number", "ConcessionsTable"."Name", "ConcessionsTable"."Continent", "ConcessionsTable"."ConstituentPermit",

                                                                 (SELECT cp."PermitNumber"
                                                                  FROM "ForestResources"."ConstituentPermitsTable" cp
                                                                  WHERE "ConcessionsTable"."ConstituentPermit" = cp."Id"
                                                                  LIMIT 1) AS ConstituentPermitNumber,

                                                             "ConcessionsTable"."Geometry", "ConcessionsTable"."ProductType", "ConcessionsTable"."Company", "ConcessionsTable"."Approved", "ConcessionsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                         FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                         WHERE "ConcessionsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                         LIMIT 1) AS email, "ConcessionsTable"."CreatedAt", "ConcessionsTable"."UpdatedAt", "ConcessionsTable"."DeletedAt";

CREATE RULE "Concessions_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Concessions" DO INSTEAD UPDATE "ForestResources"."ConcessionsTable"
                                                            SET "Name"              = new."Name",
                                                                "Number"            = new."Number",
                                                                "Continent"         = new."Continent",
                                                                "ConstituentPermit" = new."ConstituentPermit",
                                                                "Geometry"          = new."Geometry",
                                                                "ProductType"       = new."ProductType",
                                                                "Company"           = new."Company",
                                                                "Approved"          = new."Approved",
                                                                "User"              = new."User",
                                                                "UpdatedAt"         = new."UpdatedAt",
                                                                "DeletedAt"         = new."DeletedAt"
                                                            WHERE "ConcessionsTable"."Id" = old."Id"
                                                            RETURNING "ConcessionsTable"."Id", "ConcessionsTable"."Number", "ConcessionsTable"."Name", "ConcessionsTable"."Continent", "ConcessionsTable"."ConstituentPermit",

                                                             (SELECT cp."PermitNumber"
                                                                  FROM "ForestResources"."ConstituentPermitsTable" cp
                                                                  WHERE "ConcessionsTable"."ConstituentPermit" = cp."Id"
                                                                  LIMIT 1) AS ConstituentPermitNumber,

                                                             "ConcessionsTable"."Geometry", "ConcessionsTable"."ProductType", "ConcessionsTable"."Company", "ConcessionsTable"."Approved", "ConcessionsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                         FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                         WHERE "ConcessionsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                         LIMIT 1) AS email, "ConcessionsTable"."CreatedAt", "ConcessionsTable"."UpdatedAt", "ConcessionsTable"."DeletedAt";

drop view if exists "Transportation"."Permits";

create view "Transportation"."Permits"
            ("Id", "PermitNo", "PermitNoMobile", "Concession", "ManagementUnit", "DevelopmentUnit",
             "AnnualAllowableCut","AnnualAllowableCutName", "ClientCompany", "TransporterCompanyName","ConcessionaireCompany", "TransporterCompany", "User",
             "ProductType", "Status", "DriverName", "LicensePlate", "Province", "Destination", "ScanLat", "ScanLon",
             "ScanGpsAccu", "Lat", "Lon", "GpsAccu", "Geometry", "MobileId", "Approved", "ObserveAt", "CreatedAt",
             "UpdatedAt", "DeletedAt")
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
        com."Name" AS "TransporterCompanyName",
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
       per."Approved",
       per."ObserveAt",
       per."CreatedAt",
       per."UpdatedAt",
       per."DeletedAt"
FROM "Transportation"."PermitsTable" per
 LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = per."AnnualAllowableCut"
 LEFT JOIN "Taxonomy"."CompaniesTable" com ON com."Id" = per."TransporterCompany";


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
                                                       RETURNING "PermitsTable"."Id", "PermitsTable"."PermitNo", "PermitsTable"."PermitNoMobile", "PermitsTable"."Concession", "PermitsTable"."ManagementUnit", "PermitsTable"."DevelopmentUnit", "PermitsTable"."AnnualAllowableCut",

                                                             (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "PermitsTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,


                                                       "PermitsTable"."ClientCompany",

                                                        (SELECT com."Name"
                                                                  FROM "Taxonomy"."CompaniesTable" com
                                                                  WHERE "PermitsTable"."ClientCompany" = com."Id"
                                                                  LIMIT 1) AS TransporterCompanyName,

                                                       "PermitsTable"."ConcessionaireCompany", "PermitsTable"."TransporterCompany", "PermitsTable"."User", "PermitsTable"."ProductType", "PermitsTable"."Status", "PermitsTable"."DriverName", "PermitsTable"."LicensePlate", "PermitsTable"."Province", "PermitsTable"."Destination", "PermitsTable"."ScanLat", "PermitsTable"."ScanLon", "PermitsTable"."ScanGpsAccu", "PermitsTable"."Lat", "PermitsTable"."Lon", "PermitsTable"."GpsAccu", "PermitsTable"."Geometry", "PermitsTable"."MobileId", "PermitsTable"."Approved", "PermitsTable"."ObserveAt", "PermitsTable"."CreatedAt", "PermitsTable"."UpdatedAt", "PermitsTable"."DeletedAt";

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
                                                       RETURNING "PermitsTable"."Id", "PermitsTable"."PermitNo", "PermitsTable"."PermitNoMobile", "PermitsTable"."Concession", "PermitsTable"."ManagementUnit", "PermitsTable"."DevelopmentUnit", "PermitsTable"."AnnualAllowableCut",

                                                             (SELECT aac."Name"
                                                                   FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                   WHERE "PermitsTable"."AnnualAllowableCut" = aac."Id"
                                                                   LIMIT 1) AS AnnualAllowableCutName,


                                                       "PermitsTable"."ClientCompany",

                                                        (SELECT com."Name"
                                                                  FROM "Taxonomy"."CompaniesTable" com
                                                                  WHERE "PermitsTable"."ClientCompany" = com."Id"
                                                                  LIMIT 1) AS TransporterCompanyName,

                                                       "PermitsTable"."ConcessionaireCompany", "PermitsTable"."TransporterCompany", "PermitsTable"."User", "PermitsTable"."ProductType", "PermitsTable"."Status", "PermitsTable"."DriverName", "PermitsTable"."LicensePlate", "PermitsTable"."Province", "PermitsTable"."Destination", "PermitsTable"."ScanLat", "PermitsTable"."ScanLon", "PermitsTable"."ScanGpsAccu", "PermitsTable"."Lat", "PermitsTable"."Lon", "PermitsTable"."GpsAccu", "PermitsTable"."Geometry", "PermitsTable"."MobileId", "PermitsTable"."Approved", "PermitsTable"."ObserveAt", "PermitsTable"."CreatedAt", "PermitsTable"."UpdatedAt", "PermitsTable"."DeletedAt";
