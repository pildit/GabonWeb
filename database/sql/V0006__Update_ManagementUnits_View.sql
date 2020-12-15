drop view if exists "ForestResources"."ManagementUnits";
create or replace view "ForestResources"."ManagementUnits"
            ("Id", "Name", "DevelopmentUnit", "DevelopmentUnitName", "PlansList", "Geometry", "Approved", "Number", "User", "Email",
             "ProductType", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT mut."Id",
       mut."Name",
       mut."DevelopmentUnit",
       du."Name" AS "DevelopmentUnitName",
       string_agg(mp."Number", ',') as "PlansList",
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
         LEFT JOIN "ForestResources"."DevelopmentUnitsTable" du ON du."Id" = mut."DevelopmentUnit"
         LEFT JOIN "ForestResources"."ManagementPlansTable" mp ON mp."ManagementUnit" = mut."Id"
group by mut."Id", mut."Name", mut."DevelopmentUnit", du."Name", mut."Geometry", mut."Approved", mut."Number", mut."User", acc.email, mut."ProductType", mut."CreatedAt", mut."UpdatedAt", mut."DeletedAt";

CREATE RULE "ManagementUnits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ManagementUnits" DO
    INSTEAD DELETE
            FROM "ForestResources"."ManagementUnitsTable"
            WHERE "ManagementUnitsTable"."Id" = old."Id";

CREATE RULE "ManagementUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementUnits"
    DO INSTEAD INSERT INTO "ForestResources"."ManagementUnitsTable" ("Id",
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
                                                                RETURNING "ManagementUnitsTable"."Id",
                                                                    "ManagementUnitsTable"."Name",
                                                                    "ManagementUnitsTable"."DevelopmentUnit",
                                                                   (select string_agg(mp."Number", ',')
                                                                    from "ForestResources"."ManagementPlansTable" mp
                                                                    where "ManagementUnitsTable"."Id" = mp."ManagementUnit") as "PlansList",
                                                                    (SELECT du."Name"
                                                                     FROM "ForestResources"."DevelopmentUnitsTable" du
                                                                     WHERE "ManagementUnitsTable"."DevelopmentUnit" = du."Id"
                                                                     LIMIT 1) AS "DevelopmentUnitName",
                                                                    "ManagementUnitsTable"."Geometry",
                                                                    "ManagementUnitsTable"."Approved",
                                                                    "ManagementUnitsTable"."Number",
                                                                    "ManagementUnitsTable"."User",
                                                                    (SELECT acc.email
                                                                     FROM admin.accounts acc
                                                                     WHERE "ManagementUnitsTable"."User" = acc.id
                                                                     LIMIT 1) AS "Email",
                                                                    "ManagementUnitsTable"."ProductType",
                                                                    "ManagementUnitsTable"."CreatedAt",
                                                                    "ManagementUnitsTable"."UpdatedAt",
                                                                    "ManagementUnitsTable"."DeletedAt";

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
                                                                RETURNING "ManagementUnitsTable"."Id",
                                                                    "ManagementUnitsTable"."Name",
                                                                    "ManagementUnitsTable"."DevelopmentUnit",
                                                                    (select string_agg(mp."Number", ',')
                                                                     from "ForestResources"."ManagementPlansTable" mp
                                                                     where "ManagementUnitsTable"."Id" = mp."ManagementUnit") as "PlansList",
                                                                    (SELECT du."Name"
                                                                     FROM "ForestResources"."DevelopmentUnitsTable" du
                                                                     WHERE "ManagementUnitsTable"."DevelopmentUnit" = du."Id"
                                                                     LIMIT 1) AS "DevelopmentUnitName",
                                                                    "ManagementUnitsTable"."Geometry",
                                                                    "ManagementUnitsTable"."Approved",
                                                                    "ManagementUnitsTable"."Number",
                                                                    "ManagementUnitsTable"."User",
                                                                    (SELECT acc.email
                                                                     FROM admin.accounts acc
                                                                     WHERE "ManagementUnitsTable"."User" = acc.id
                                                                     LIMIT 1) AS "Email",
                                                                    "ManagementUnitsTable"."ProductType",
                                                                    "ManagementUnitsTable"."CreatedAt",
                                                                    "ManagementUnitsTable"."UpdatedAt",
                                                                    "ManagementUnitsTable"."DeletedAt";
