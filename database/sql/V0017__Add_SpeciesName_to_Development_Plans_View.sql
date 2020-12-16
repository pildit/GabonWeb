drop view if exists "ForestResources"."DevelopmentPlans";
create view "ForestResources"."DevelopmentPlans"
            ("Id", "DevelopmentUnit", "Number", "Species", "SpeciesCommonName", "MinimumExploitableDiameter", "VolumeTariff", "Increment",
             "Approved", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT dpt."Id",
       dpt."DevelopmentUnit",
       dpt."Number",
       dpt."Species",
       sp."CommonName" as "SpeciesCommonName",
       dpt."MinimumExploitableDiameter",
       dpt."VolumeTariff",
       dpt."Increment",
       dpt."Approved",
       dpt."CreatedAt",
       dpt."UpdatedAt",
       dpt."DeletedAt"
FROM "ForestResources"."DevelopmentPlansTable" dpt
LEFT JOIN "Taxonomy"."Species" sp on dpt."Species" = sp."Id";

CREATE RULE "DevelopmentPlans_instead_of_delete" AS
    ON DELETE TO "ForestResources"."DevelopmentPlans"
    DO INSTEAD DELETE
     FROM "ForestResources"."DevelopmentPlansTable"
     WHERE "DevelopmentPlansTable"."Id" = old."Id";

CREATE RULE "DevelopmentPlans_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentPlans"
    DO INSTEAD INSERT INTO "ForestResources"."DevelopmentPlansTable" ("Id",
                                                                    "DevelopmentUnit",
                                                                    "Number",
                                                                    "Species",
                                                                    "MinimumExploitableDiameter",
                                                                    "VolumeTariff",
                                                                    "Increment",
                                                                    "Approved",
                                                                    "CreatedAt",
                                                                    "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_DevelopmentPlans"'::regclass),
                                                                         new."DevelopmentUnit", new."Number",
                                                                         new."Species",
                                                                         new."MinimumExploitableDiameter",
                                                                         new."VolumeTariff", new."Increment",
                                                                         new."Approved", new."CreatedAt",
                                                                         new."UpdatedAt")
                                                                 RETURNING "DevelopmentPlansTable"."Id",
                                                                     "DevelopmentPlansTable"."DevelopmentUnit",
                                                                     "DevelopmentPlansTable"."Number",
                                                                     "DevelopmentPlansTable"."Species",
                                                                     (select sp."CommonName" from "Taxonomy"."Species" sp where "DevelopmentPlansTable"."Species" = sp."Id" limit 1),
                                                                     "DevelopmentPlansTable"."MinimumExploitableDiameter",
                                                                     "DevelopmentPlansTable"."VolumeTariff",
                                                                     "DevelopmentPlansTable"."Increment",
                                                                     "DevelopmentPlansTable"."Approved",
                                                                     "DevelopmentPlansTable"."CreatedAt",
                                                                     "DevelopmentPlansTable"."UpdatedAt",
                                                                     "DevelopmentPlansTable"."DeletedAt";

CREATE RULE "DevelopmentPlans_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentPlans" DO INSTEAD UPDATE "ForestResources"."DevelopmentPlansTable"
                                                                 SET "DevelopmentUnit"            = new."DevelopmentUnit",
                                                                     "Number"                     = new."Number",
                                                                     "Species"                    = new."Species",
                                                                     "MinimumExploitableDiameter" = new."MinimumExploitableDiameter",
                                                                     "VolumeTariff"               = new."VolumeTariff",
                                                                     "Increment"                  = new."Increment",
                                                                     "Approved"                   = new."Approved",
                                                                     "UpdatedAt"                  = new."UpdatedAt",
                                                                     "DeletedAt"                  = new."DeletedAt"
                                                                 WHERE "DevelopmentPlansTable"."Id" = old."Id"
                                                                 RETURNING "DevelopmentPlansTable"."Id",
                                                                     "DevelopmentPlansTable"."DevelopmentUnit",
                                                                     "DevelopmentPlansTable"."Number",
                                                                     "DevelopmentPlansTable"."Species",
                                                                     (select sp."CommonName" from "Taxonomy"."Species" sp where "DevelopmentPlansTable"."Species" = sp."Id" limit 1),
                                                                     "DevelopmentPlansTable"."MinimumExploitableDiameter",
                                                                     "DevelopmentPlansTable"."VolumeTariff",
                                                                     "DevelopmentPlansTable"."Increment",
                                                                     "DevelopmentPlansTable"."Approved",
                                                                     "DevelopmentPlansTable"."CreatedAt",
                                                                     "DevelopmentPlansTable"."UpdatedAt",
                                                                     "DevelopmentPlansTable"."DeletedAt";
