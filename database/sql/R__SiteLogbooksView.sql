create or replace view "ForestResources"."SiteLogbooks"
            ("Id", "AnnualAllowableCut", "AnnualAllowableCutName", "ManagementUnit", "ManagementUnitName",
             "DevelopmentUnit", "DevelopmentUnitName", "Concession", "ConcessionName", "Company", "CompanyName",
             "Hammer", "Localization", "ReportNo", "ReportNote", "ObserveAt", "Approved", "MobileId", "CreatedAt",
             "UpdatedAt", "DeletedAt")
as
SELECT slb."Id",
       slb."AnnualAllowableCut",
       aac."Name" AS "AnnualAllowableCutName",
       slb."ManagementUnit",
       mu."Name"  AS "ManagementUnitName",
       slb."DevelopmentUnit",
       du."Name"  AS "DevelopmentUnitName",
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
         LEFT JOIN "ForestResources"."ManagementUnitsTable" mu ON slb."ManagementUnit" = mu."Id"
         LEFT JOIN "ForestResources"."DevelopmentUnitsTable" du ON slb."DevelopmentUnit" = du."Id"
         LEFT JOIN "Taxonomy"."CompaniesTable" com ON com."Id" = slb."Company";


CREATE OR REPLACE RULE "SiteLogbooks_instead_of_delete" AS
    ON DELETE TO "ForestResources"."SiteLogbooks" DO INSTEAD DELETE
                                                             FROM "ForestResources"."SiteLogbooksTable"
                                                             WHERE "SiteLogbooksTable"."Id" = old."Id";

CREATE OR REPLACE RULE "SiteLogbooks_instead_of_insert" AS
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
                                                             RETURNING "SiteLogbooksTable"."Id", "SiteLogbooksTable"."AnnualAllowableCut", (SELECT aac."Name"
                                                                                                                                            FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                                                                                            WHERE "SiteLogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                                                                                                            LIMIT 1) AS "AnnualAllowableCutName", "SiteLogbooksTable"."ManagementUnit", (SELECT mu."Name"
                                                                                                                                                                                                                         FROM "ForestResources"."ManagementUnitsTable" mu
                                                                                                                                                                                                                         WHERE "SiteLogbooksTable"."ManagementUnit" = mu."Id"
                                                                                                                                                                                                                         LIMIT 1) AS "Name", "SiteLogbooksTable"."DevelopmentUnit", (SELECT du."Name"
                                                                                                                                                                                                                                                                                     FROM "ForestResources"."DevelopmentUnitsTable" du
                                                                                                                                                                                                                                                                                     WHERE "SiteLogbooksTable"."DevelopmentUnit" = du."Id"
                                                                                                                                                                                                                                                                                     LIMIT 1) AS "Name", "SiteLogbooksTable"."Concession", (SELECT con."Name"
                                                                                                                                                                                                                                                                                                                                            FROM "ForestResources"."ConcessionsTable" con
                                                                                                                                                                                                                                                                                                                                            WHERE "SiteLogbooksTable"."Concession" = con."Id"
                                                                                                                                                                                                                                                                                                                                            LIMIT 1) AS "ConcessionName", "SiteLogbooksTable"."Company", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                          FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                          WHERE "SiteLogbooksTable"."Company" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                          LIMIT 1) AS companyname, "SiteLogbooksTable"."Hammer", "SiteLogbooksTable"."Localization", "SiteLogbooksTable"."ReportNo", "SiteLogbooksTable"."ReportNote", "SiteLogbooksTable"."ObserveAt", "SiteLogbooksTable"."Approved", "SiteLogbooksTable"."MobileId", "SiteLogbooksTable"."CreatedAt", "SiteLogbooksTable"."UpdatedAt", "SiteLogbooksTable"."DeletedAt";

CREATE OR REPLACE RULE "SiteLogbooks_instead_of_update" AS
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
                                                             RETURNING "SiteLogbooksTable"."Id", "SiteLogbooksTable"."AnnualAllowableCut", (SELECT aac."Name"
                                                                                                                                            FROM "ForestResources"."AnnualAllowableCutsTable" aac
                                                                                                                                            WHERE "SiteLogbooksTable"."AnnualAllowableCut" = aac."Id"
                                                                                                                                            LIMIT 1) AS "AnnualAllowableCutName", "SiteLogbooksTable"."ManagementUnit", (SELECT mu."Name"
                                                                                                                                                                                                                         FROM "ForestResources"."ManagementUnitsTable" mu
                                                                                                                                                                                                                         WHERE "SiteLogbooksTable"."ManagementUnit" = mu."Id"
                                                                                                                                                                                                                         LIMIT 1) AS "Name", "SiteLogbooksTable"."DevelopmentUnit", (SELECT du."Name"
                                                                                                                                                                                                                                                                                     FROM "ForestResources"."DevelopmentUnitsTable" du
                                                                                                                                                                                                                                                                                     WHERE "SiteLogbooksTable"."DevelopmentUnit" = du."Id"
                                                                                                                                                                                                                                                                                     LIMIT 1) AS "Name", "SiteLogbooksTable"."Concession", (SELECT con."Name"
                                                                                                                                                                                                                                                                                                                                            FROM "ForestResources"."ConcessionsTable" con
                                                                                                                                                                                                                                                                                                                                            WHERE "SiteLogbooksTable"."Concession" = con."Id"
                                                                                                                                                                                                                                                                                                                                            LIMIT 1) AS "ConcessionName", "SiteLogbooksTable"."Company", (SELECT com."Name"
                                                                                                                                                                                                                                                                                                                                                                                                          FROM "Taxonomy"."CompaniesTable" com
                                                                                                                                                                                                                                                                                                                                                                                                          WHERE "SiteLogbooksTable"."Company" = com."Id"
                                                                                                                                                                                                                                                                                                                                                                                                          LIMIT 1) AS companyname, "SiteLogbooksTable"."Hammer", "SiteLogbooksTable"."Localization", "SiteLogbooksTable"."ReportNo", "SiteLogbooksTable"."ReportNote", "SiteLogbooksTable"."ObserveAt", "SiteLogbooksTable"."Approved", "SiteLogbooksTable"."MobileId", "SiteLogbooksTable"."CreatedAt", "SiteLogbooksTable"."UpdatedAt", "SiteLogbooksTable"."DeletedAt";

