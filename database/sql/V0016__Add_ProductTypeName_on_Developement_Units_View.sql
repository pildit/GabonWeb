drop view if exists "ForestResources"."DevelopmentUnits";
create or replace view "ForestResources"."DevelopmentUnits"
            ("Id", "Name", "Concession", "ConcessionName", "Start", "End", "PlansList", "Geometry", "Approved", "Number", "User",
             "Email", "ProductType", "ProductTypeName", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT du."Id",
       du."Name",
       du."Concession",
       con."Name" AS "ConcessionName",
       du."Start",
       du."End",
       string_agg(dp."Number", ',') as "PlansList",
       du."Geometry",
       du."Approved",
       du."Number",
       du."User",
       acc.email  AS "Email",
       du."ProductType",
       pt."Name" as "ProductTypeName",
       du."CreatedAt",
       du."UpdatedAt",
       du."DeletedAt"
FROM "ForestResources"."DevelopmentUnitsTable" du
         LEFT JOIN admin.accounts acc ON du."User" = acc.id
         LEFT JOIN "ForestResources"."ConcessionsTable" con ON du."Concession" = con."Id"
         LEFT JOIN "ForestResources"."DevelopmentPlansTable" dp on dp."DevelopmentUnit" = du."Id"
         LEFT JOIN "Taxonomy"."ProductTypeTable" pt on du."ProductType" = pt."Id"
group by du."Id", du."Name", du."Concession", con."Name", du."Start", du."End", du."Geometry", du."Approved", du."Number", du."User", acc.email, du."ProductType", pt."Name", du."CreatedAt", du."UpdatedAt", du."DeletedAt";


CREATE RULE "DevelopmentUnits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."DevelopmentUnits"
    DO INSTEAD DELETE
             FROM "ForestResources"."DevelopmentUnitsTable"
             WHERE "DevelopmentUnitsTable"."Id" = old."Id";

CREATE RULE "DevelopmentUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentUnits"
        DO INSTEAD INSERT INTO "ForestResources"."DevelopmentUnitsTable" ("Id",
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
                                                                 RETURNING "DevelopmentUnitsTable"."Id",
                                                                     "DevelopmentUnitsTable"."Name",
                                                                     "DevelopmentUnitsTable"."Concession",
                                                                     (SELECT con."Name"
                                                                        FROM "ForestResources"."ConcessionsTable" con
                                                                        WHERE "DevelopmentUnitsTable"."Concession" = con."Id"
                                                                        LIMIT 1) AS concessionname,
                                                                     "DevelopmentUnitsTable"."Start",
                                                                     "DevelopmentUnitsTable"."End",
                                                                     (select string_agg(dp."Number", ',')
                                                                     from "ForestResources"."DevelopmentPlansTable" dp
                                                                     where "DevelopmentUnitsTable"."Id" = dp."DevelopmentUnit") as "PlanList",
                                                                     "DevelopmentUnitsTable"."Geometry",
                                                                     "DevelopmentUnitsTable"."Approved",
                                                                     "DevelopmentUnitsTable"."Number",
                                                                     "DevelopmentUnitsTable"."User",
                                                                     (SELECT acc.email
                                                                       FROM admin.accounts acc
                                                                       WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                       LIMIT 1) AS email,
                                                                     "DevelopmentUnitsTable"."ProductType",
                                                                     (SELECT pt."Name"
                                                                         FROM "Taxonomy"."ProductTypeTable" pt
                                                                         WHERE "DevelopmentUnitsTable"."ProductType" = pt."Id"
                                                                         LIMIT 1),
                                                                     "DevelopmentUnitsTable"."CreatedAt",
                                                                     "DevelopmentUnitsTable"."UpdatedAt",
                                                                     "DevelopmentUnitsTable"."DeletedAt";

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
                                                                 RETURNING "DevelopmentUnitsTable"."Id",
                                                                     "DevelopmentUnitsTable"."Name",
                                                                     "DevelopmentUnitsTable"."Concession",
                                                                     (SELECT con."Name"
                                                                      FROM "ForestResources"."ConcessionsTable" con
                                                                      WHERE "DevelopmentUnitsTable"."Concession" = con."Id"
                                                                      LIMIT 1) AS concessionname,
                                                                     "DevelopmentUnitsTable"."Start",
                                                                     "DevelopmentUnitsTable"."End",
                                                                     (select string_agg(dp."Number", ',')
                                                                      from "ForestResources"."DevelopmentPlansTable" dp
                                                                      where "DevelopmentUnitsTable"."Id" = dp."DevelopmentUnit") as "PlanList",
                                                                     "DevelopmentUnitsTable"."Geometry",
                                                                     "DevelopmentUnitsTable"."Approved",
                                                                     "DevelopmentUnitsTable"."Number",
                                                                     "DevelopmentUnitsTable"."User",
                                                                     (SELECT acc.email
                                                                      FROM admin.accounts acc
                                                                      WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                      LIMIT 1) AS email,
                                                                     "DevelopmentUnitsTable"."ProductType",
                                                                     (SELECT pt."Name"
                                                                      FROM "Taxonomy"."ProductTypeTable" pt
                                                                      WHERE "DevelopmentUnitsTable"."ProductType" = pt."Id"
                                                                      LIMIT 1),
                                                                     "DevelopmentUnitsTable"."CreatedAt",
                                                                     "DevelopmentUnitsTable"."UpdatedAt",
                                                                     "DevelopmentUnitsTable"."DeletedAt";
