create or replace view "ForestResources"."AnnualAllowableCuts"
            ("Id", "Name", "AacId", "ManagementUnit", "ManagementUnitName", "ManagementPlan", "PlansList", "Geometry",
             "ProductType", "ProductTypeName", "User", "Email", "Approved", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT aac."Id",
       aac."Name",
       aac."AacId",
       aac."ManagementUnit",
       mu."Name"                                  AS "ManagementUnitName",
       aac."ManagementPlan",
       string_agg(aaco."Number"::text, ','::text) AS "PlansList",
       aac."Geometry",
       aac."ProductType",
       pt."Name"                                  AS "ProductTypeName",
       aac."User",
       acc.email                                  AS "Email",
       aac."Approved",
       aac."CreatedAt",
       aac."UpdatedAt",
       aac."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutsTable" aac
         LEFT JOIN "ForestResources"."ManagementUnitsTable" mu ON mu."Id" = aac."ManagementUnit"
         LEFT JOIN admin.accounts acc ON acc.id = aac."User"
         LEFT JOIN "ForestResources"."AnnualOperationPlansTable" aaco ON aaco."AnnualAllowableCut" = aac."Id"
         LEFT JOIN "Taxonomy"."ProductTypeTable" pt ON aac."ProductType" = pt."Id"
GROUP BY aac."Id", aac."Name", aac."AacId", aac."ManagementUnit", mu."Name", aac."ManagementPlan", aac."Geometry",
         aac."ProductType", pt."Name", aac."User", acc.email, aac."Approved", aac."CreatedAt", aac."UpdatedAt",
         aac."DeletedAt";

alter table "ForestResources"."AnnualAllowableCuts"
    owner to homestead;

CREATE OR REPLACE RULE "AnnualAllowableCuts_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD DELETE
                                                                    FROM "ForestResources"."AnnualAllowableCutsTable"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "AnnualAllowableCuts_instead_of_insert" AS
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
                                                                            new."Geometry", new."ProductType",
                                                                            new."User", new."Approved", new."CreatedAt",
                                                                            new."UpdatedAt")
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit", (SELECT mu."Name"
                                                                                                                                                                                                                                    FROM "ForestResources"."ManagementUnitsTable" mu
                                                                                                                                                                                                                                    WHERE "AnnualAllowableCutsTable"."ManagementUnit" = mu."Id"
                                                                                                                                                                                                                                    LIMIT 1) AS "ManagementUnitName", "AnnualAllowableCutsTable"."ManagementPlan", (SELECT string_agg(aaco."Number"::text, ','::text) AS string_agg
                                                                                                                                                                                                                                                                                                                    FROM "ForestResources"."AnnualOperationPlansTable" aaco
                                                                                                                                                                                                                                                                                                                    WHERE "AnnualAllowableCutsTable"."Id" = aaco."AnnualAllowableCut"
                                                                                                                                                                                                                                                                                                                    LIMIT 1) AS "PlanList", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", (SELECT pt."Name"
                                                                                                                                                                                                                                                                                                                                                                                                                              FROM "Taxonomy"."ProductTypeTable" pt
                                                                                                                                                                                                                                                                                                                                                                                                                              WHERE "AnnualAllowableCutsTable"."ProductType" = pt."Id"
                                                                                                                                                                                                                                                                                                                                                                                                                              LIMIT 1) AS "Name", "AnnualAllowableCutsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      WHERE "AnnualAllowableCutsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      LIMIT 1) AS "Email", "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";

CREATE OR REPLACE RULE "AnnualAllowableCuts_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD UPDATE "ForestResources"."AnnualAllowableCutsTable"
                                                                    SET "Name"           = new."Name",
                                                                        "AacId"          = new."AacId",
                                                                        "ManagementUnit" = new."ManagementUnit",
                                                                        "ManagementPlan" = new."ManagementPlan",
                                                                        "Geometry"       = new."Geometry",
                                                                        "ProductType"    = new."ProductType",
                                                                        "User"           = new."User",
                                                                        "Approved"       = new."Approved",
                                                                        "UpdatedAt"      = new."UpdatedAt",
                                                                        "DeletedAt"      = new."DeletedAt"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id"
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit", (SELECT mu."Name"
                                                                                                                                                                                                                                    FROM "ForestResources"."ManagementUnitsTable" mu
                                                                                                                                                                                                                                    WHERE "AnnualAllowableCutsTable"."ManagementUnit" = mu."Id"
                                                                                                                                                                                                                                    LIMIT 1) AS "ManagementUnitName", "AnnualAllowableCutsTable"."ManagementPlan", (SELECT string_agg(aaco."Number"::text, ','::text) AS string_agg
                                                                                                                                                                                                                                                                                                                    FROM "ForestResources"."AnnualOperationPlansTable" aaco
                                                                                                                                                                                                                                                                                                                    WHERE "AnnualAllowableCutsTable"."Id" = aaco."AnnualAllowableCut"
                                                                                                                                                                                                                                                                                                                    LIMIT 1) AS "PlanList", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", (SELECT pt."Name"
                                                                                                                                                                                                                                                                                                                                                                                                                              FROM "Taxonomy"."ProductTypeTable" pt
                                                                                                                                                                                                                                                                                                                                                                                                                              WHERE "AnnualAllowableCutsTable"."ProductType" = pt."Id"
                                                                                                                                                                                                                                                                                                                                                                                                                              LIMIT 1) AS "Name", "AnnualAllowableCutsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      WHERE "AnnualAllowableCutsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      LIMIT 1) AS "Email", "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";

