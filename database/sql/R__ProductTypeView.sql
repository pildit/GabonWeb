create or replace view "Taxonomy"."ProductType"("Id", "Name", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT "ProductTypeTable"."Id",
       "ProductTypeTable"."Name",
       "ProductTypeTable"."User",
       acc.email AS "Email",
       "ProductTypeTable"."CreatedAt",
       "ProductTypeTable"."UpdatedAt",
       "ProductTypeTable"."DeletedAt"
FROM "Taxonomy"."ProductTypeTable"
         LEFT JOIN admin.accounts acc ON "ProductTypeTable"."User" = acc.id;

alter table "Taxonomy"."ProductType"
    owner to homestead;

CREATE OR REPLACE RULE "ProductType_instead_of_delete" AS
    ON DELETE TO "Taxonomy"."ProductType" DO INSTEAD DELETE
                                                     FROM "Taxonomy"."ProductTypeTable"
                                                     WHERE "ProductTypeTable"."Id" = old."Id";

CREATE OR REPLACE RULE "ProductType_instead_of_insert" AS
    ON INSERT TO "Taxonomy"."ProductType" DO INSTEAD INSERT INTO "Taxonomy"."ProductTypeTable" ("Name", "User", "CreatedAt")
                                                     VALUES (new."Name", new."User", new."CreatedAt")
                                                     RETURNING "ProductTypeTable"."Id", "ProductTypeTable"."Name", "ProductTypeTable"."User", (SELECT acc.email
                                                                                                                                               FROM admin.accounts acc
                                                                                                                                               WHERE "ProductTypeTable"."User" = acc.id
                                                                                                                                               LIMIT 1) AS "Email", "ProductTypeTable"."CreatedAt", "ProductTypeTable"."UpdatedAt", "ProductTypeTable"."DeletedAt";

CREATE OR REPLACE RULE "ProductType_instead_of_update" AS
    ON UPDATE TO "Taxonomy"."ProductType" DO INSTEAD UPDATE "Taxonomy"."ProductTypeTable"
                                                     SET "Name"      = new."Name",
                                                         "UpdatedAt" = new."UpdatedAt",
                                                         "DeletedAt" = new."DeletedAt"
                                                     WHERE "ProductTypeTable"."Id" = old."Id"
                                                     RETURNING "ProductTypeTable"."Id", "ProductTypeTable"."Name", "ProductTypeTable"."User", (SELECT acc.email
                                                                                                                                               FROM admin.accounts acc
                                                                                                                                               WHERE "ProductTypeTable"."User" = acc.id
                                                                                                                                               LIMIT 1) AS "Email", "ProductTypeTable"."CreatedAt", "ProductTypeTable"."UpdatedAt", "ProductTypeTable"."DeletedAt";

