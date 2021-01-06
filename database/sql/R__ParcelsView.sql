create or replace view "ForestResources"."Parcels"
            ("Id", "Name", "Geometry", "Approved", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT pt."Id",
       pt."Name",
       pt."Geometry",
       pt."Approved",
       pt."User",
       acc.email AS "Email",
       pt."CreatedAt",
       pt."UpdatedAt",
       pt."DeletedAt"
FROM "ForestResources"."ParcelsTable" pt
         LEFT JOIN admin.accounts acc ON acc.id = pt."User";


CREATE OR REPLACE RULE "Parcels_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Parcels" DO INSTEAD DELETE
                                                        FROM "ForestResources"."ParcelsTable"
                                                        WHERE "ParcelsTable"."Id" = old."Id";

CREATE OR REPLACE RULE "Parcels_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Parcels" DO INSTEAD INSERT INTO "ForestResources"."ParcelsTable" ("Id",
                                                                                                      "ResourceType",
                                                                                                      "Name",
                                                                                                      "Geometry",
                                                                                                      "CreatedAt",
                                                                                                      "Approved",
                                                                                                      "User")
                                                        VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                (SELECT rt."Id"
                                                                 FROM "ForestResources"."ResourceTypes" rt
                                                                 WHERE rt."Name" = 'Parcel'::text
                                                                 LIMIT 1), new."Name", new."Geometry", new."CreatedAt",
                                                                new."Approved", new."User")
                                                        RETURNING "ParcelsTable"."Id", "ParcelsTable"."Name", "ParcelsTable"."Geometry", "ParcelsTable"."Approved", "ParcelsTable"."User", (SELECT acc.email
                                                                                                                                                                                            FROM admin.accounts acc
                                                                                                                                                                                            WHERE "ParcelsTable"."User" = acc.id
                                                                                                                                                                                            LIMIT 1) AS email, "ParcelsTable"."CreatedAt", "ParcelsTable"."UpdatedAt", "ParcelsTable"."DeletedAt";

CREATE OR REPLACE RULE "Parcels_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Parcels" DO INSTEAD UPDATE "ForestResources"."ParcelsTable"
                                                        SET "Name"      = new."Name",
                                                            "Geometry"  = new."Geometry",
                                                            "Approved"  = new."Approved",
                                                            "UpdatedAt" = new."UpdatedAt",
                                                            "DeletedAt" = new."DeletedAt"
                                                        WHERE "ParcelsTable"."Id" = old."Id"
                                                        RETURNING "ParcelsTable"."Id", "ParcelsTable"."Name", "ParcelsTable"."Geometry", "ParcelsTable"."Approved", "ParcelsTable"."User", (SELECT acc.email
                                                                                                                                                                                            FROM admin.accounts acc
                                                                                                                                                                                            WHERE "ParcelsTable"."User" = acc.id
                                                                                                                                                                                            LIMIT 1) AS email, "ParcelsTable"."CreatedAt", "ParcelsTable"."UpdatedAt", "ParcelsTable"."DeletedAt";

