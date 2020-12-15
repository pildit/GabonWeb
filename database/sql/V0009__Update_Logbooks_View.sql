drop view if exists "ForestResources"."Logbooks";
create or replace view "ForestResources"."Logbooks"
            ("Id", "Concession", "ConcessionName", "DevelopmentUnit", "DevelopmentUnitName", "ManagementUnit", "ManagementUnitName", "AnnualAllowableCut",
             "AnnualAllowableCutName", "ObserveAt", "Approved", "MobileId", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT lb."Id",
       lb."Concession",
       con."Name" AS "ConcessionName",
       lb."DevelopmentUnit",
       du."Name" as "DevelopmentUnitName",
       lb."ManagementUnit",
       mu."Name" as "ManagementUnitName",
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
         LEFT JOIN "ForestResources"."AnnualAllowableCutsTable" aac ON aac."Id" = lb."AnnualAllowableCut"
         LEFT JOIN "ForestResources"."DevelopmentUnitsTable" du ON du."Id" = lb."DevelopmentUnit"
         LEFT JOIN "ForestResources"."ManagementUnitsTable" mu ON mu."Id" = lb."ManagementUnit";

CREATE RULE "Logbooks_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Logbooks"
    DO INSTEAD DELETE
             FROM "ForestResources"."LogbooksTable"
             WHERE "LogbooksTable"."Id" = old."Id";

CREATE RULE "Logbooks_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Logbooks"
    DO INSTEAD INSERT INTO "ForestResources"."LogbooksTable" ("Id",
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
                                                         RETURNING "LogbooksTable"."Id",
                                                             "LogbooksTable"."Concession",
                                                             (SELECT con."Name"
                                                            FROM "ForestResources"."ConcessionsTable" con
                                                            WHERE "LogbooksTable"."Concession" = con."Id"
                                                            LIMIT 1) AS "ConcessionName",
                                                             "LogbooksTable"."DevelopmentUnit",
                                                             (select du."Name"
                                                             from "ForestResources"."DevelopmentUnitsTable" du
                                                             where du."Id" = "LogbooksTable"."DevelopmentUnit"
                                                             limit 1) as "DevelopmentUnitName",
                                                             "LogbooksTable"."ManagementUnit",
                                                                (select mu."Name"
                                                                from "ForestResources"."ManagementUnitsTable" mu
                                                                where mu."Id" = "LogbooksTable"."ManagementUnit"
                                                                limit 1) as "ManagementUnitName",
                                                             "LogbooksTable"."AnnualAllowableCut",
                                                             (SELECT aac."Name"
                                                            FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                            WHERE "LogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                            LIMIT 1) AS "AnnualAllowableCutName",
                                                             "LogbooksTable"."ObserveAt",
                                                             "LogbooksTable"."Approved",
                                                             "LogbooksTable"."MobileId",
                                                             "LogbooksTable"."CreatedAt",
                                                             "LogbooksTable"."UpdatedAt",
                                                             "LogbooksTable"."DeletedAt";

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
                                                         RETURNING "LogbooksTable"."Id",
                                                             "LogbooksTable"."Concession",
                                                             (SELECT con."Name"
                                                              FROM "ForestResources"."ConcessionsTable" con
                                                              WHERE "LogbooksTable"."Concession" = con."Id"
                                                              LIMIT 1) AS "ConcessionName",
                                                             "LogbooksTable"."DevelopmentUnit",
                                                             (select du."Name"
                                                              from "ForestResources"."DevelopmentUnitsTable" du
                                                              where du."Id" = "LogbooksTable"."DevelopmentUnit"
                                                              limit 1) as "DevelopmentUnitName",
                                                             "LogbooksTable"."ManagementUnit",
                                                             (select mu."Name"
                                                              from "ForestResources"."ManagementUnitsTable" mu
                                                              where mu."Id" = "LogbooksTable"."ManagementUnit"
                                                              limit 1) as "ManagementUnitName",
                                                             "LogbooksTable"."AnnualAllowableCut",
                                                             (SELECT aac."Name"
                                                              FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                              WHERE "LogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                              LIMIT 1) AS "AnnualAllowableCutName",
                                                             "LogbooksTable"."ObserveAt",
                                                             "LogbooksTable"."Approved",
                                                             "LogbooksTable"."MobileId",
                                                             "LogbooksTable"."CreatedAt",
                                                             "LogbooksTable"."UpdatedAt",
                                                             "LogbooksTable"."DeletedAt";
