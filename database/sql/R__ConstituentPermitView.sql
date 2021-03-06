drop view if exists "ForestResources"."ConstituentPermits";
create or replace view "ForestResources"."ConstituentPermits"
            ("Id", "User","Concession", "Email", "PermitType", "PermitNumber", "PermitTypeName",
                "Geometry", "Approved", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT cpt."Id",
       cpt."User",
       cpt."Concession",
       acc.email AS "Email",
       cpt."PermitType",
       cpt."PermitNumber",
       ptt."Name" as PermitTypeName,
       cpt."Geometry",
       cpt."Approved",
       cpt."CreatedAt",
       cpt."UpdatedAt",
       cpt."DeletedAt"
FROM "ForestResources"."ConstituentPermitsTable" cpt
         LEFT JOIN admin.accounts acc on cpt."User" = acc.id
         LEFT JOIN "ForestResources"."PermitTypesTable" ptt on cpt."PermitType" = ptt."Id";

alter table "ForestResources"."ConstituentPermits"
    owner to postgres;

CREATE or replace RULE "ConstituentPermits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ConstituentPermits" DO INSTEAD INSERT INTO "ForestResources"."ConstituentPermitsTable" ("Id",
                                                                                                                            "User",
                                                                                                                            "Concession",
                                                                                                                            "PermitType",
                                                                                                                            "PermitNumber",
                                                                                                                            "Geometry",
                                                                                                                            "Approved",
                                                                                                                            "CreatedAt")
                                                                   VALUES (nextval('"ForestResources"."SEQ_ConstituentPermits"'::regclass),
                                                                           new."User",new."Concession", new."PermitType",
                                                                           new."PermitNumber", new."Geometry",
                                                                           new."Approved", new."CreatedAt")
                                                                   RETURNING "ConstituentPermitsTable"."Id",
                                                                       "ConstituentPermitsTable"."User",
                                                                       "ConstituentPermitsTable"."Concession",
                                                                       (SELECT acc.email
                                                                        FROM admin.accounts acc
                                                                        WHERE "ConstituentPermitsTable"."User" = acc.id) AS email,
                                                                       "ConstituentPermitsTable"."PermitType",
                                                                       "ConstituentPermitsTable"."PermitNumber",
                                                                       (SELECT ptt."Name"
                                                                        FROM "ForestResources"."PermitTypesTable" ptt
                                                                        WHERE "ConstituentPermitsTable"."PermitType" = ptt."Id"
                                                                        LIMIT 1) as "PermitTypeName",
                                                                       "ConstituentPermitsTable"."Geometry",
                                                                       "ConstituentPermitsTable"."Approved",
                                                                       "ConstituentPermitsTable"."CreatedAt",
                                                                       "ConstituentPermitsTable"."UpdatedAt",
                                                                       "ConstituentPermitsTable"."DeletedAt";

CREATE or replace RULE "ConstituentPermits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ConstituentPermits" DO INSTEAD UPDATE "ForestResources"."ConstituentPermitsTable"
                                                                   SET "User"         = new."User",
                                                                     "Concession"         = new."Concession",
                                                                       "PermitType"   = new."PermitType",
                                                                       "PermitNumber" = new."PermitNumber",
                                                                       "Geometry"     = new."Geometry",
                                                                       "Approved"     = new."Approved",
                                                                       "UpdatedAt"    = new."UpdatedAt",
                                                                       "DeletedAt"    = new."DeletedAt"
                                                                   WHERE "ConstituentPermitsTable"."Id" = old."Id"
                                                                   RETURNING "ConstituentPermitsTable"."Id",
                                                                       "ConstituentPermitsTable"."User",
                                                                       "ConstituentPermitsTable"."Concession",
                                                                       (SELECT acc.email
                                                                        FROM admin.accounts acc
                                                                        WHERE "ConstituentPermitsTable"."User" = acc.id) AS email,
                                                                       "ConstituentPermitsTable"."PermitType",
                                                                       "ConstituentPermitsTable"."PermitNumber",
                                                                       (SELECT ptt."Name"
                                                                        FROM "ForestResources"."PermitTypesTable" ptt
                                                                        WHERE "ConstituentPermitsTable"."PermitType" = ptt."Id"
                                                                        LIMIT 1) as "PermitTypeName",
                                                                       "ConstituentPermitsTable"."Geometry",
                                                                       "ConstituentPermitsTable"."Approved",
                                                                       "ConstituentPermitsTable"."CreatedAt",
                                                                       "ConstituentPermitsTable"."UpdatedAt",
                                                                       "ConstituentPermitsTable"."DeletedAt";
