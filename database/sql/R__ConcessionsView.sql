
create or replace view "ForestResources"."Concessions"
            ("Id", "Number", "Name", "Continent", "ConstituentPermitNumber", "Geometry",
             "ProductType","ProductTypeName", "Company","CompanyName", "Approved", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT ct."Id",
       ct."Number",
       ct."Name",
       ct."Continent",
       string_agg(cp."PermitNumber", ',') as "ConstituentPermitNumber",
       ct."Geometry",
       ct."ProductType",
       pt."Name" as "ProductTypeName",
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
         LEFT JOIN "ForestResources"."ConstituentPermitsTable" cp ON ct."Id" = cp."Concession"
         LEFT JOIN "Taxonomy"."ProductTypeTable" pt on ct."ProductType" = pt."Id"
         LEFT JOIN "Taxonomy"."CompaniesTable" com on ct."Company" = com."Id"
group by ct."Id", ct."Number", ct."Name", ct."Continent", cp."PermitNumber", ct."Geometry",
         ct."ProductType",pt."Name", ct."Company",com."Name", ct."Approved", ct."User", acc."email", ct."CreatedAt", ct."UpdatedAt", ct."DeletedAt";

alter table "ForestResources"."Concessions"
    owner to homestead;

CREATE or replace RULE "Concessions_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Concessions" DO INSTEAD DELETE
                                                            FROM "ForestResources"."ConcessionsTable"
                                                            WHERE "ConcessionsTable"."Id" = old."Id";

CREATE or replace RULE "Concessions_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Concessions" DO INSTEAD INSERT INTO "ForestResources"."ConcessionsTable" ("Id",
                                                                                                              "ResourceType",
                                                                                                              "Number",
                                                                                                              "Name",
                                                                                                              "Continent",
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
                                                                    new."Continent",
                                                                    new."Geometry", new."ProductType", new."Company",
                                                                    new."Approved", new."User", new."CreatedAt",
                                                                    new."UpdatedAt")
                                                            RETURNING "ConcessionsTable"."Id", "ConcessionsTable"."Number", "ConcessionsTable"."Name", "ConcessionsTable"."Continent", (          select string_agg(cp."PermitNumber", ',')
                                                                                                                                                                                                                                FROM "ForestResources"."ConstituentPermitsTable" cp
                                                                                                                                                                                                                                WHERE "ConcessionsTable"."Id" = cp."Concession"
                                                                                                                                                                                                                                LIMIT 1) AS constituentpermitnumber, "ConcessionsTable"."Geometry", "ConcessionsTable"."ProductType",
                                                                                                                                                                                                                                     (SELECT pt."Name"
                                                                FROM "Taxonomy"."ProductTypeTable" pt
                                                                WHERE "ConcessionsTable"."ProductType" = pt."Id"
                                                                LIMIT 1),

                                                                                                                                                                                                                                 "ConcessionsTable"."Company",
                                                                                                                                                                                                                                (select com."Name"
                                                                from "Taxonomy"."CompaniesTable" com
                                                                where "ConcessionsTable"."Company" = com."Id"
                                                                limit 1) as "CompanyName",
                                                                                                                                                                                                                                "ConcessionsTable"."Approved", "ConcessionsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                   FROM admin.accounts acc
                                                                                                                                                                                                                                                                   WHERE "ConcessionsTable"."User" = acc.id
                                                                                                                                                                                                                                                                   LIMIT 1) AS email, "ConcessionsTable"."CreatedAt", "ConcessionsTable"."UpdatedAt", "ConcessionsTable"."DeletedAt";

CREATE or replace RULE "Concessions_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Concessions" DO INSTEAD UPDATE "ForestResources"."ConcessionsTable"
                                                            SET "Name"              = new."Name",
                                                                "Number"            = new."Number",
                                                                "Continent"         = new."Continent",
                                                                "Geometry"          = new."Geometry",
                                                                "ProductType"       = new."ProductType",
                                                                "Company"           = new."Company",
                                                                "Approved"          = new."Approved",
                                                                "User"              = new."User",
                                                                "UpdatedAt"         = new."UpdatedAt",
                                                                "DeletedAt"         = new."DeletedAt"
                                                            WHERE "ConcessionsTable"."Id" = old."Id"
                                                                                RETURNING "ConcessionsTable"."Id", "ConcessionsTable"."Number", "ConcessionsTable"."Name", "ConcessionsTable"."Continent", (          select string_agg(cp."PermitNumber", ',')
                                                                                                                                                                                                                                FROM "ForestResources"."ConstituentPermitsTable" cp
                                                                                                                                                                                                                                WHERE "ConcessionsTable"."Id" = cp."Concession"
                                                                                                                                                                                                                                LIMIT 1) AS constituentpermitnumber, "ConcessionsTable"."Geometry", "ConcessionsTable"."ProductType",
                                                                                                                                                                                                                                     (SELECT pt."Name"
                                                                FROM "Taxonomy"."ProductTypeTable" pt
                                                                WHERE "ConcessionsTable"."ProductType" = pt."Id"
                                                                LIMIT 1),

                                                                                                                                                                                                                                 "ConcessionsTable"."Company",
                                                                                                                                                                                                                                (select com."Name"
                                                                from "Taxonomy"."CompaniesTable" com
                                                                where "ConcessionsTable"."Company" = com."Id"
                                                                limit 1) as "CompanyName",
                                                                                                                                                                                                                                "ConcessionsTable"."Approved", "ConcessionsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                   FROM admin.accounts acc
                                                                                                                                                                                                                                                                   WHERE "ConcessionsTable"."User" = acc.id
                                                                                                                                                                                                                                                                   LIMIT 1) AS email, "ConcessionsTable"."CreatedAt", "ConcessionsTable"."UpdatedAt", "ConcessionsTable"."DeletedAt";
