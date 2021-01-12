drop view "ForestResources"."ManagementPlans";
create or replace view "ForestResources"."ManagementPlans"
            ("Id", "ManagementUnit", "Number", "Species", "SpeciesCommonName", "GrossVolumeUFG", "GrossVolumeYear", "YieldVolumeYear",
             "CommercialVolumeYear", "Approved", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT mpt."Id",
       mpt."ManagementUnit",
       mpt."Number",
       mpt."Species",
        sp."CommonName" AS "SpeciesCommonName",
       mpt."GrossVolumeUFG",
       mpt."GrossVolumeYear",
       mpt."YieldVolumeYear",
       mpt."CommercialVolumeYear",
       mpt."Approved",
       mpt."CreatedAt",
       mpt."UpdatedAt",
       mpt."DeletedAt"
FROM "ForestResources"."ManagementPlansTable" mpt
 LEFT JOIN "Taxonomy"."SpeciesTable" sp ON mpt."Species" = sp."Id";

CREATE OR REPLACE RULE "ManagementPlans_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ManagementPlans" DO INSTEAD DELETE
                                                                FROM "ForestResources"."ManagementPlansTable"
                                                                WHERE "ManagementPlansTable"."Id" = old."Id";

CREATE OR REPLACE RULE "ManagementPlans_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementPlans" DO INSTEAD INSERT INTO "ForestResources"."ManagementPlansTable" ("Id",
                                                                                                                      "ManagementUnit",
                                                                                                                      "Number",
                                                                                                                      "Species",
                                                                                                                      "GrossVolumeUFG",
                                                                                                                      "GrossVolumeYear",
                                                                                                                      "YieldVolumeYear",
                                                                                                                      "CommercialVolumeYear",
                                                                                                                      "Approved",
                                                                                                                      "CreatedAt",
                                                                                                                      "UpdatedAt")
                                                                VALUES (nextval('"ForestResources"."SEQ_ManagementPlans"'::regclass),
                                                                        new."ManagementUnit", new."Number",
                                                                        new."Species", new."GrossVolumeUFG",
                                                                        new."GrossVolumeYear", new."YieldVolumeYear",
                                                                        new."CommercialVolumeYear", new."Approved",
                                                                        new."CreatedAt", new."UpdatedAt")
                                                                RETURNING "ManagementPlansTable"."Id", "ManagementPlansTable"."ManagementUnit", "ManagementPlansTable"."Number", "ManagementPlansTable"."Species", (SELECT sp."CommonName"
                                                                                                                                                                                                                          FROM "Taxonomy"."SpeciesTable" sp
                                                                                                                                                                                                                          WHERE "ManagementPlansTable"."Species" = sp."Id"
                                                                                                                                                                                                                          LIMIT 1) AS "CommonName", "ManagementPlansTable"."GrossVolumeUFG", "ManagementPlansTable"."GrossVolumeYear", "ManagementPlansTable"."YieldVolumeYear", "ManagementPlansTable"."CommercialVolumeYear", "ManagementPlansTable"."Approved", "ManagementPlansTable"."CreatedAt", "ManagementPlansTable"."UpdatedAt", "ManagementPlansTable"."DeletedAt";

CREATE OR REPLACE RULE "ManagementPlans_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ManagementPlans" DO INSTEAD UPDATE "ForestResources"."ManagementPlansTable"
                                                                SET "ManagementUnit"       = new."ManagementUnit",
                                                                    "Number"               = new."Number",
                                                                    "Species"              = new."Species",
                                                                    "GrossVolumeUFG"       = new."GrossVolumeUFG",
                                                                    "GrossVolumeYear"      = new."GrossVolumeYear",
                                                                    "YieldVolumeYear"      = new."YieldVolumeYear",
                                                                    "CommercialVolumeYear" = new."CommercialVolumeYear",
                                                                    "Approved"             = new."Approved",
                                                                    "UpdatedAt"            = new."UpdatedAt",
                                                                    "DeletedAt"            = new."DeletedAt"
                                                                WHERE "ManagementPlansTable"."Id" = old."Id"
                                                                RETURNING "ManagementPlansTable"."Id", "ManagementPlansTable"."ManagementUnit", "ManagementPlansTable"."Number", "ManagementPlansTable"."Species", (SELECT sp."CommonName"
                                                                                                                                                                                                                          FROM "Taxonomy"."SpeciesTable" sp
                                                                                                                                                                                                                          WHERE "ManagementPlansTable"."Species" = sp."Id"
                                                                                                                                                                                                                          LIMIT 1) AS "CommonName", "ManagementPlansTable"."GrossVolumeUFG", "ManagementPlansTable"."GrossVolumeYear", "ManagementPlansTable"."YieldVolumeYear", "ManagementPlansTable"."CommercialVolumeYear", "ManagementPlansTable"."Approved", "ManagementPlansTable"."CreatedAt", "ManagementPlansTable"."UpdatedAt", "ManagementPlansTable"."DeletedAt";

