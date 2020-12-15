drop view if exists "ForestResources"."Concessions";
create or replace view "ForestResources"."Concessions"
            ("Id", "Number", "Name", "Continent", "ConstituentPermit", "ConstituentPermitNumber", "Geometry",
             "ProductType", "Company", "CompanyName", "Approved", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt")
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
       com."Name" as "CompanyName",
       ct."Approved",
       ct."User",
       acc.email         AS "Email",
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."ConcessionsTable" ct
         LEFT JOIN admin.accounts acc ON ct."User" = acc.id
         LEFT JOIN "ForestResources"."ConstituentPermitsTable" cp ON ct."ConstituentPermit" = cp."Id"
         LEFT JOIN "Taxonomy"."CompaniesTable" com on ct."Company" = com."Id";

CREATE RULE "Concessions_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Concessions"
    DO INSTEAD DELETE
                FROM "ForestResources"."ConcessionsTable"
                WHERE "ConcessionsTable"."Id" = old."Id";

CREATE RULE "Concessions_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Concessions"
    DO INSTEAD INSERT INTO "ForestResources"."ConcessionsTable" ("Id",
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
                                                            RETURNING "ConcessionsTable"."Id",
                                                                "ConcessionsTable"."Number",
                                                                "ConcessionsTable"."Name",
                                                                "ConcessionsTable"."Continent",
                                                                "ConcessionsTable"."ConstituentPermit",
                                                                (SELECT cp."PermitNumber"
                                                                FROM "ForestResources"."ConstituentPermitsTable" cp
                                                                WHERE "ConcessionsTable"."ConstituentPermit" = cp."Id"
                                                                LIMIT 1) AS "ConstituentPermitNumber",
                                                                "ConcessionsTable"."Geometry",
                                                                "ConcessionsTable"."ProductType",
                                                                "ConcessionsTable"."Company",
                                                                (select com."Name"
                                                                from "Taxonomy"."CompaniesTable" com
                                                                where "ConcessionsTable"."Company" = com."Id"
                                                                limit 1) as "CompanyName",
                                                                "ConcessionsTable"."Approved",
                                                                "ConcessionsTable"."User",
                                                                (SELECT acc.email
                                                               FROM admin.accounts acc
                                                               WHERE "ConcessionsTable"."User" = acc.id
                                                               LIMIT 1) AS "Email",
                                                                "ConcessionsTable"."CreatedAt",
                                                                "ConcessionsTable"."UpdatedAt",
                                                                "ConcessionsTable"."DeletedAt";

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
                                                            RETURNING "ConcessionsTable"."Id",
                                                                "ConcessionsTable"."Number",
                                                                "ConcessionsTable"."Name",
                                                                "ConcessionsTable"."Continent",
                                                                "ConcessionsTable"."ConstituentPermit",
                                                                (SELECT cp."PermitNumber"
                                                                 FROM "ForestResources"."ConstituentPermitsTable" cp
                                                                 WHERE "ConcessionsTable"."ConstituentPermit" = cp."Id"
                                                                 LIMIT 1) AS "ConstituentPermitNumber",
                                                                "ConcessionsTable"."Geometry",
                                                                "ConcessionsTable"."ProductType",
                                                                "ConcessionsTable"."Company",
                                                                (select com."Name"
                                                                 from "Taxonomy"."CompaniesTable" com
                                                                 where "ConcessionsTable"."Company" = com."Id"
                                                                 limit 1) as "CompanyName",
                                                                "ConcessionsTable"."Approved",
                                                                "ConcessionsTable"."User",
                                                                (SELECT acc.email
                                                                 FROM admin.accounts acc
                                                                 WHERE "ConcessionsTable"."User" = acc.id
                                                                 LIMIT 1) AS "Email",
                                                                "ConcessionsTable"."CreatedAt",
                                                                "ConcessionsTable"."UpdatedAt",
                                                                "ConcessionsTable"."DeletedAt";
