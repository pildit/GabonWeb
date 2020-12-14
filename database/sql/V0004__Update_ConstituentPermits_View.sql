drop view if exists "ForestResources"."ConstituentPermits";
create or replace view "ForestResources"."ConstituentPermits"
            ("Id", "User", "Email", "PermitType", "PermitTypeName", "PermitNumber", "Geometry", "Approved", "CreatedAt", "UpdatedAt",
             "DeletedAt") as
SELECT cpt."Id",
       cpt."User",
       acc.email AS "Email",
       cpt."PermitType",
       ptt."Name" as PermitTypeName,
       cpt."PermitNumber",
       cpt."Geometry",
       cpt."Approved",
       cpt."CreatedAt",
       cpt."UpdatedAt",
       cpt."DeletedAt"
FROM "ForestResources"."ConstituentPermitsTable" cpt
    LEFT JOIN admin.accounts acc on cpt."User" = acc.id
    LEFT JOIN "ForestResources"."PermitTypesTable" ptt on cpt."PermitType" = ptt."Id";

CREATE RULE "ConstituentPermits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ConstituentPermits"
    DO INSTEAD INSERT INTO "ForestResources"."ConstituentPermitsTable" ("Id",
                                                                        "User",
                                                                        "PermitType",
                                                                        "PermitNumber",
                                                                        "Geometry",
                                                                        "Approved",
                                                                        "CreatedAt")
                                                                   VALUES (nextval('"ForestResources"."SEQ_ConstituentPermits"'::regclass),
                                                                           new."User", new."PermitType",
                                                                           new."PermitNumber", new."Geometry",
                                                                           new."Approved", new."CreatedAt")
                                                                   RETURNING "ConstituentPermitsTable"."Id",
                                                                       "ConstituentPermitsTable"."User",
                                                                       (SELECT acc.email
                                                                        FROM admin.accounts acc
                                                                        WHERE "ConstituentPermitsTable"."User" = acc.id) AS "Email",
                                                                       "ConstituentPermitsTable"."PermitType",
                                                                       (SELECT ptt."Name"
                                                                           FROM "ForestResources"."PermitTypesTable" ptt
                                                                           WHERE "ConstituentPermitsTable"."PermitType" = ptt."Id"
                                                                       LIMIT 1) as "PermitTypeName",
                                                                       "ConstituentPermitsTable"."PermitNumber",
                                                                       "ConstituentPermitsTable"."Geometry",
                                                                       "ConstituentPermitsTable"."Approved",
                                                                       "ConstituentPermitsTable"."CreatedAt",
                                                                       "ConstituentPermitsTable"."UpdatedAt",
                                                                       "ConstituentPermitsTable"."DeletedAt";

CREATE RULE "ConstituentPermits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ConstituentPermits"
    DO INSTEAD UPDATE "ForestResources"."ConstituentPermitsTable"
                       SET "User"         = new."User",
                           "PermitType"   = new."PermitType",
                           "PermitNumber" = new."PermitNumber",
                           "Geometry"     = new."Geometry",
                           "Approved"     = new."Approved",
                           "UpdatedAt"    = new."UpdatedAt",
                           "DeletedAt"    = new."DeletedAt"
                       WHERE "ConstituentPermitsTable"."Id" = old."Id"
               RETURNING "ConstituentPermitsTable"."Id",
                   "ConstituentPermitsTable"."User",
                   (SELECT acc.email
                    FROM admin.accounts acc
                    WHERE "ConstituentPermitsTable"."User" = acc.id) AS "Email",
                   "ConstituentPermitsTable"."PermitType",
                   (SELECT ptt."Name"
                    FROM "ForestResources"."PermitTypesTable" ptt
                    WHERE "ConstituentPermitsTable"."PermitType" = ptt."Id"
                    LIMIT 1) as "PermitTypeName",
                   "ConstituentPermitsTable"."PermitNumber",
                   "ConstituentPermitsTable"."Geometry",
                   "ConstituentPermitsTable"."Approved",
                   "ConstituentPermitsTable"."CreatedAt",
                   "ConstituentPermitsTable"."UpdatedAt",
                   "ConstituentPermitsTable"."DeletedAt";
