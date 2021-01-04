create or replace view "Taxonomy"."Species"
            ("Id", "Code", "LatinName", "CommonName", "User", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT st."Id",
       st."Code",
       st."LatinName",
       st."CommonName",
       st."User",
       st."CreatedAt",
       st."UpdatedAt",
       st."DeletedAt"
FROM "Taxonomy"."SpeciesTable" st
         LEFT JOIN admin.accounts acc ON st."User" = acc.id;

CREATE OR REPLACE RULE "Species_instead_of_delete" AS
    ON DELETE TO "Taxonomy"."Species" DO INSTEAD DELETE
                                                 FROM "Taxonomy"."SpeciesTable"
                                                 WHERE "SpeciesTable"."Id" = old."Id";

CREATE OR REPLACE RULE "Species_instead_of_insert" AS
    ON INSERT TO "Taxonomy"."Species" DO INSTEAD INSERT INTO "Taxonomy"."SpeciesTable" ("Id", "Code", "LatinName", "CommonName", "User", "CreatedAt")
                                                 VALUES (nextval('"Taxonomy"."SEQ_Species"'::regclass), new."Code",
                                                         new."LatinName", new."CommonName", new."User", new."CreatedAt")
                                                 RETURNING "SpeciesTable"."Id", "SpeciesTable"."Code", "SpeciesTable"."LatinName", "SpeciesTable"."CommonName", "SpeciesTable"."User", "SpeciesTable"."CreatedAt", "SpeciesTable"."UpdatedAt", "SpeciesTable"."DeletedAt";

CREATE OR REPLACE RULE "Species_instead_of_update" AS
    ON UPDATE TO "Taxonomy"."Species" DO INSTEAD UPDATE "Taxonomy"."SpeciesTable"
                                                 SET "Code"       = new."Code",
                                                     "LatinName"  = new."LatinName",
                                                     "CommonName" = new."CommonName",
                                                     "UpdatedAt"  = new."UpdatedAt",
                                                     "DeletedAt"  = new."DeletedAt"
                                                 WHERE "SpeciesTable"."Id" = old."Id"
                                                 RETURNING "SpeciesTable"."Id", "SpeciesTable"."Code", "SpeciesTable"."LatinName", "SpeciesTable"."CommonName", "SpeciesTable"."User", "SpeciesTable"."CreatedAt", "SpeciesTable"."UpdatedAt", "SpeciesTable"."DeletedAt";

