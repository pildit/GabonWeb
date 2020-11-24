alter table "ForestResources"."ConcessionsTable"
    add "User" int;

alter table "ForestResources"."ConcessionsTable"
    add constraint concessionstable_accounts_id_fk
        foreign key ("User") references admin.accounts;


drop view if exists "ForestResources"."Concessions";

create view "ForestResources"."Concessions"
            ("Id", "Name", "Continent", "ConstituentPermit", "Geometry", "Company", "Approved", "User", "Email", "CreatedAt",
             "UpdatedAt", "DeletedAt")
as
SELECT ct."Id",
       ct."Name",
       ct."Continent",
       ct."ConstituentPermit",
       ct."Geometry",
       ct."Company",
       ct."Approved",
       ct."User",
       acc.email as "Email",
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."ConcessionsTable" ct
left join admin.accounts acc on ct."User" = acc.id;

CREATE RULE "Concessions_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Concessions" DO INSTEAD
INSERT INTO "ForestResources"."ConcessionsTable" ("Id",
                                                  "ResourceType",
                                                  "Name",
                                                  "Continent",
                                                  "ConstituentPermit",
                                                  "Geometry",
                                                  "Company",
                                                  "Approved",
                                                  "User",
                                                  "CreatedAt",
                                                  "UpdatedAt")
                                                            VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                    (SELECT rt."Id"
                                                                     FROM "ForestResources"."ResourceTypes" rt
                                                                     WHERE rt."Name" = 'Concession'::text
                                                                     LIMIT 1), new."Name", new."Continent",
                                                                    new."ConstituentPermit", new."Geometry",
                                                                    new."Company", new."Approved",
                                                                    new."User",
                                                                    new."CreatedAt",
                                                                    new."UpdatedAt")
                                                            RETURNING
                                                                "Id",
                                                                "Name",
                                                                "Continent",
                                                                "ConstituentPermit",
                                                                "Geometry",
                                                                "Company",
                                                                "Approved",
                                                                "User",
                                                                (SELECT acc.email
                                                                 FROM admin.accounts acc
                                                                 WHERE "ConcessionsTable"."User" = acc.id limit 1) AS email,
                                                                "CreatedAt",
                                                                "UpdatedAt",
                                                                "DeletedAt";

CREATE RULE "Concessions_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Concessions" DO INSTEAD UPDATE "ForestResources"."ConcessionsTable"
                                                            SET "Name"              = new."Name",
                                                                "Continent"         = new."Continent",
                                                                "ConstituentPermit" = new."ConstituentPermit",
                                                                "Geometry"          = new."Geometry",
                                                                "Company"           = new."Company",
                                                                "Approved"          = new."Approved",
                                                                "User"              = new."User",
                                                                "UpdatedAt"         = new."UpdatedAt",
                                                                "DeletedAt"         = new."DeletedAt"
                                                            WHERE "ConcessionsTable"."Id" = old."Id"
                                                            RETURNING "Id",
                                                                "Name",
                                                                "Continent",
                                                                "ConstituentPermit",
                                                                "Geometry",
                                                                "Company",
                                                                "Approved",
                                                                "User",
                                                                (SELECT acc.email
                                                                 FROM admin.accounts acc
                                                                 WHERE "ConcessionsTable"."User" = acc.id limit 1) AS email,
                                                                "CreatedAt",
                                                                "UpdatedAt",
                                                                "DeletedAt";

CREATE RULE "Concessions_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Concessions" DO INSTEAD  DELETE FROM "ForestResources"."ConcessionsTable"
  WHERE "ConcessionsTable"."Id" = old."Id";
