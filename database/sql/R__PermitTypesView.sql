create or replace view "ForestResources"."PermitTypes"
            ("Id", "Name", "Abbreviation", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT pt."Id",
       pt."Name",
       pt."Abbreviation",
       pt."User",
       acc.email AS "Email",
       pt."CreatedAt",
       pt."UpdatedAt",
       pt."DeletedAt"
FROM "ForestResources"."PermitTypesTable" pt
         LEFT JOIN admin.accounts acc ON acc.id = pt."User";


CREATE OR REPLACE RULE "PermitTypes_instead_of_insert" AS
    ON INSERT TO "ForestResources"."PermitTypes" DO INSTEAD INSERT INTO "ForestResources"."PermitTypesTable" ("Id", "Name", "Abbreviation", "User", "CreatedAt", "UpdatedAt")
                                                            VALUES (nextval('"ForestResources"."SEQ_PermitTypes"'::regclass),
                                                                    new."Name", new."Abbreviation", new."User",
                                                                    new."CreatedAt", new."UpdatedAt")
                                                            RETURNING "PermitTypesTable"."Id", "PermitTypesTable"."Name", "PermitTypesTable"."Abbreviation", "PermitTypesTable"."User", (SELECT acc.email
                                                                                                                                                                                         FROM admin.accounts acc
                                                                                                                                                                                         WHERE acc.id = "PermitTypesTable"."User"
                                                                                                                                                                                         LIMIT 1) AS email, "PermitTypesTable"."CreatedAt", "PermitTypesTable"."UpdatedAt", "PermitTypesTable"."DeletedAt";

CREATE OR REPLACE RULE "PermitTypes_instead_of_update" AS
    ON UPDATE TO "ForestResources"."PermitTypes" DO INSTEAD UPDATE "ForestResources"."PermitTypesTable"
                                                            SET "Name"         = new."Name",
                                                                "Abbreviation" = new."Abbreviation",
                                                                "UpdatedAt"    = new."UpdatedAt",
                                                                "DeletedAt"    = new."DeletedAt"
                                                            WHERE "PermitTypesTable"."Id" = old."Id"
                                                            RETURNING "PermitTypesTable"."Id", "PermitTypesTable"."Name", "PermitTypesTable"."Abbreviation", "PermitTypesTable"."User", (SELECT acc.email
                                                                                                                                                                                         FROM admin.accounts acc
                                                                                                                                                                                         WHERE acc.id = "PermitTypesTable"."User"
                                                                                                                                                                                         LIMIT 1) AS email, "PermitTypesTable"."CreatedAt", "PermitTypesTable"."UpdatedAt", "PermitTypesTable"."DeletedAt";

CREATE OR REPLACE RULE "PermitTypes_instead_of_delete" AS
    ON DELETE TO "ForestResources"."PermitTypes" DO INSTEAD DELETE
                                                            FROM "ForestResources"."PermitTypesTable"
                                                            WHERE "PermitTypesTable"."Id" = old."Id";

