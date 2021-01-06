create or replace view "ForestResources"."AnnualOperationPlans"
            ("Id", "AnnualAllowableCut", "Number", "Species", "ExploitableVolume", "NonExploitableVolume",
             "VolumePerHectare", "AverageVolume", "TotalVolume", "Approved", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT aopt."Id",
       aopt."AnnualAllowableCut",
       aopt."Number",
       aopt."Species",
       aopt."ExploitableVolume",
       aopt."NonExploitableVolume",
       aopt."VolumePerHectare",
       aopt."AverageVolume",
       aopt."TotalVolume",
       aopt."Approved",
       aopt."CreatedAt",
       aopt."UpdatedAt",
       aopt."DeletedAt"
FROM "ForestResources"."AnnualOperationPlansTable" aopt;


CREATE OR REPLACE RULE "AnnualOperationPlans_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualOperationPlans" DO INSTEAD DELETE
                                                                     FROM "ForestResources"."AnnualOperationPlansTable"
                                                                     WHERE "AnnualOperationPlansTable"."Id" = old."Id";

CREATE OR REPLACE RULE "AnnualOperationPlans_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualOperationPlans" DO INSTEAD INSERT INTO "ForestResources"."AnnualOperationPlansTable" ("Id",
                                                                                                                                "AnnualAllowableCut",
                                                                                                                                "Number",
                                                                                                                                "Species",
                                                                                                                                "ExploitableVolume",
                                                                                                                                "NonExploitableVolume",
                                                                                                                                "VolumePerHectare",
                                                                                                                                "AverageVolume",
                                                                                                                                "Approved",
                                                                                                                                "CreatedAt",
                                                                                                                                "UpdatedAt")
                                                                     VALUES (nextval('"ForestResources"."SEQ_AnnualOperationPlans"'::regclass),
                                                                             new."AnnualAllowableCut", new."Number",
                                                                             new."Species", new."ExploitableVolume",
                                                                             new."NonExploitableVolume",
                                                                             new."VolumePerHectare",
                                                                             new."AverageVolume", new."Approved",
                                                                             new."CreatedAt", new."UpdatedAt")
                                                                     RETURNING "AnnualOperationPlansTable"."Id", "AnnualOperationPlansTable"."AnnualAllowableCut", "AnnualOperationPlansTable"."Number", "AnnualOperationPlansTable"."Species", "AnnualOperationPlansTable"."ExploitableVolume", "AnnualOperationPlansTable"."NonExploitableVolume", "AnnualOperationPlansTable"."VolumePerHectare", "AnnualOperationPlansTable"."AverageVolume", "AnnualOperationPlansTable"."TotalVolume", "AnnualOperationPlansTable"."Approved", "AnnualOperationPlansTable"."CreatedAt", "AnnualOperationPlansTable"."UpdatedAt", "AnnualOperationPlansTable"."DeletedAt";

CREATE OR REPLACE RULE "AnnualOperationPlans_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualOperationPlans" DO INSTEAD UPDATE "ForestResources"."AnnualOperationPlansTable"
                                                                     SET "AnnualAllowableCut"   = new."AnnualAllowableCut",
                                                                         "Number"               = new."Number",
                                                                         "Species"              = new."Species",
                                                                         "ExploitableVolume"    = new."ExploitableVolume",
                                                                         "NonExploitableVolume" = new."NonExploitableVolume",
                                                                         "VolumePerHectare"     = new."VolumePerHectare",
                                                                         "AverageVolume"        = new."AverageVolume",
                                                                         "Approved"             = new."Approved",
                                                                         "UpdatedAt"            = new."UpdatedAt",
                                                                         "DeletedAt"            = new."DeletedAt"
                                                                     WHERE "AnnualOperationPlansTable"."Id" = old."Id"
                                                                     RETURNING "AnnualOperationPlansTable"."Id", "AnnualOperationPlansTable"."AnnualAllowableCut", "AnnualOperationPlansTable"."Number", "AnnualOperationPlansTable"."Species", "AnnualOperationPlansTable"."ExploitableVolume", "AnnualOperationPlansTable"."NonExploitableVolume", "AnnualOperationPlansTable"."VolumePerHectare", "AnnualOperationPlansTable"."AverageVolume", "AnnualOperationPlansTable"."TotalVolume", "AnnualOperationPlansTable"."Approved", "AnnualOperationPlansTable"."CreatedAt", "AnnualOperationPlansTable"."UpdatedAt", "AnnualOperationPlansTable"."DeletedAt";

