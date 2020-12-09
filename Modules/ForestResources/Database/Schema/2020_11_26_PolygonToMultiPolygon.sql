drop view if exists "ForestResources"."BaseResources";
drop view if exists "ForestResources"."AnnualAllowableCuts";
drop view if exists "ForestResources"."Concessions";
drop view if exists "ForestResources"."DevelopmentUnits";
drop view if exists "ForestResources"."ManagementUnits";
drop view if exists "ForestResources"."Parcels";

drop function "ForestResources"."BaseResources_insteadof_delete"();

drop function "ForestResources"."BaseResources_insteadof_insert"();

drop function "ForestResources"."BaseResources_insteadof_update"();


ALTER TABLE "ForestResources"."BaseResourcesTable" ALTER COLUMN "Geometry"
    SET DATA TYPE geometry(MultiPolygon,5223) USING ST_Multi("Geometry");

drop view if exists "ForestResources"."ConstituentPermits";

ALTER TABLE "ForestResources"."ConstituentPermitsTable" ALTER COLUMN "Geometry"
    SET DATA TYPE geometry(MultiPolygon,5223) USING ST_Multi("Geometry");


----------
-- VIEW --
----------
create view "ForestResources"."BaseResources"
as
select
    brt."Id"
     , brt."ResourceType"
     , brt."Name"
     , brt."Geometry"
from
    "ForestResources"."BaseResourcesTable" as brt
;


-------------------------
-- Instead-of Triggers --
-------------------------

-- Instead of Insert

create function "ForestResources"."BaseResources_insteadof_insert" ()
    returns trigger
    language plpgsql
    volatile
    called on null input
    security invoker
    cost 100
as $$
begin
    raise exception 'A ForestResources.BaseResource cannot be inserted by itself.';
end;
$$;

create trigger "TRIG_ForestResources.BaseResources_insteadof_insert"
    instead of insert
    on "ForestResources"."BaseResources"
    for each row
execute procedure "ForestResources"."BaseResources_insteadof_insert"()
;


-- Instead of Delete

create function "ForestResources"."BaseResources_insteadof_delete" ()
    returns trigger
    language plpgsql
    volatile
    called on null input
    security invoker
    cost 100
as $$
begin
    raise exception 'A ForestResources.BaseResource cannot be deleted by itself.';
end;
$$;

create trigger "TRIG_ForestResources.BaseResources_insteadof_delete"
    instead of delete
    on "ForestResources"."BaseResources"
    for each row
execute procedure "ForestResources"."BaseResources_insteadof_delete"()
;


-- Instead of Update

create function "ForestResources"."BaseResources_insteadof_update" ()
    returns trigger
    language plpgsql
    volatile
    called on null input
    security invoker
    cost 100
as $$
begin
    raise exception 'A ForestResources.BaseResource cannot be updated by itself.';
end;
$$;

create trigger "TRIG_ForestResources.BaseResources_insteadof_update"
    instead of update
    on "ForestResources"."BaseResources"
    for each row
execute procedure "ForestResources"."BaseResources_insteadof_update"()
;

create view "ForestResources"."AnnualAllowableCuts"
            ("Id", "Name", "AacId", "ManagementUnit", "ManagementPlan", "Geometry", "ProductType", "Approved",
             "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT mut."Id",
       mut."Name",
       mut."AacId",
       mut."ManagementUnit",
       mut."ManagementPlan",
       mut."Geometry",
       mut."ProductType",
       mut."Approved",
       mut."CreatedAt",
       mut."UpdatedAt",
       mut."DeletedAt"
FROM "ForestResources"."AnnualAllowableCutsTable" mut;

alter table "ForestResources"."AnnualAllowableCuts"
    owner to postgres;

CREATE RULE "AnnualAllowableCuts_instead_of_delete" AS
    ON DELETE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD DELETE
                                                                    FROM "ForestResources"."AnnualAllowableCutsTable"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id";

CREATE RULE "AnnualAllowableCuts_instead_of_insert" AS
    ON INSERT TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD INSERT INTO "ForestResources"."AnnualAllowableCutsTable" ("Id",
                                                                                                                              "ResourceType",
                                                                                                                              "Name",
                                                                                                                              "AacId",
                                                                                                                              "ManagementUnit",
                                                                                                                              "ManagementPlan",
                                                                                                                              "Geometry",
                                                                                                                              "ProductType",
                                                                                                                              "Approved",
                                                                                                                              "CreatedAt",
                                                                                                                              "UpdatedAt")
                                                                    VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                            (SELECT rt."Id"
                                                                             FROM "ForestResources"."ResourceTypes" rt
                                                                             WHERE rt."Name" = 'Annual Allowable Cut'::text
                                                                             LIMIT 1), new."Name", new."AacId",
                                                                            new."ManagementUnit", new."ManagementPlan",
                                                                            new."Geometry", new."ProductType",
                                                                            new."Approved", new."CreatedAt",
                                                                            new."UpdatedAt")
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit", "AnnualAllowableCutsTable"."ManagementPlan", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";

CREATE RULE "AnnualAllowableCuts_instead_of_update" AS
    ON UPDATE TO "ForestResources"."AnnualAllowableCuts" DO INSTEAD UPDATE "ForestResources"."AnnualAllowableCutsTable"
                                                                    SET "Name"           = new."Name",
                                                                        "AacId"          = new."AacId",
                                                                        "ManagementUnit" = new."ManagementUnit",
                                                                        "ManagementPlan" = new."ManagementPlan",
                                                                        "Geometry"       = new."Geometry",
                                                                        "ProductType"    = new."ProductType",
                                                                        "Approved"       = new."Approved",
                                                                        "UpdatedAt"      = new."UpdatedAt",
                                                                        "DeletedAt"      = new."DeletedAt"
                                                                    WHERE "AnnualAllowableCutsTable"."Id" = old."Id"
                                                                    RETURNING "AnnualAllowableCutsTable"."Id", "AnnualAllowableCutsTable"."Name", "AnnualAllowableCutsTable"."AacId", "AnnualAllowableCutsTable"."ManagementUnit", "AnnualAllowableCutsTable"."ManagementPlan", "AnnualAllowableCutsTable"."Geometry", "AnnualAllowableCutsTable"."ProductType", "AnnualAllowableCutsTable"."Approved", "AnnualAllowableCutsTable"."CreatedAt", "AnnualAllowableCutsTable"."UpdatedAt", "AnnualAllowableCutsTable"."DeletedAt";




create view "ForestResources"."Concessions"
            ("Id", "Number", "Name", "Continent", "ConstituentPermit", "Geometry", "ProductType", "Company", "Approved",
             "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT ct."Id",
       ct."Number",
       ct."Name",
       ct."Continent",
       ct."ConstituentPermit",
       ct."Geometry",
       ct."ProductType",
       ct."Company",
       ct."Approved",
       ct."User",
       acc.email AS "Email",
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."ConcessionsTable" ct
         LEFT JOIN admin.accounts acc ON ct."User" = acc.id;

alter table "ForestResources"."Concessions"
    owner to postgres;

CREATE RULE "Concessions_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Concessions" DO INSTEAD DELETE
                                                            FROM "ForestResources"."ConcessionsTable"
                                                            WHERE "ConcessionsTable"."Id" = old."Id";

CREATE RULE "Concessions_instead_of_insert" AS
    ON INSERT TO "ForestResources"."Concessions" DO INSTEAD INSERT INTO "ForestResources"."ConcessionsTable" ("Id",
                                                                                                              "ResourceType",
                                                                                                              "Number",
                                                                                                              "Name",
                                                                                                              "Continent",
                                                                                                              "ConstituentPermit",
                                                                                                              "Geometry",
                                                                                                              "ProductType",
                                                                                                              "Company",
                                                                                                              "Approved",
                                                                                                              "User",
                                                                                                              "CreatedAt",
                                                                                                              "UpdatedAt")
                                                            VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                    (SELECT rt."Id"
                                                                     FROM "ForestResources"."ResourceTypes" rt
                                                                     WHERE rt."Name" = 'Concession'::text
                                                                     LIMIT 1), new."Name", new."Number",
                                                                    new."Continent", new."ConstituentPermit",
                                                                    new."Geometry", new."ProductType", new."Company",
                                                                    new."Approved", new."User", new."CreatedAt",
                                                                    new."UpdatedAt")
                                                            RETURNING "ConcessionsTable"."Id", "ConcessionsTable"."Number", "ConcessionsTable"."Name", "ConcessionsTable"."Continent", "ConcessionsTable"."ConstituentPermit", "ConcessionsTable"."Geometry", "ConcessionsTable"."ProductType", "ConcessionsTable"."Company", "ConcessionsTable"."Approved", "ConcessionsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                         FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                         WHERE "ConcessionsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                         LIMIT 1) AS email, "ConcessionsTable"."CreatedAt", "ConcessionsTable"."UpdatedAt", "ConcessionsTable"."DeletedAt";

CREATE RULE "Concessions_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Concessions" DO INSTEAD UPDATE "ForestResources"."ConcessionsTable"
                                                            SET "Name"              = new."Name",
                                                                "Number"            = new."Number",
                                                                "Continent"         = new."Continent",
                                                                "ConstituentPermit" = new."ConstituentPermit",
                                                                "Geometry"          = new."Geometry",
                                                                "ProductType"       = new."ProductType",
                                                                "Company"           = new."Company",
                                                                "Approved"          = new."Approved",
                                                                "User"              = new."User",
                                                                "UpdatedAt"         = new."UpdatedAt",
                                                                "DeletedAt"         = new."DeletedAt"
                                                            WHERE "ConcessionsTable"."Id" = old."Id"
                                                            RETURNING "ConcessionsTable"."Id", "ConcessionsTable"."Number", "ConcessionsTable"."Name", "ConcessionsTable"."Continent", "ConcessionsTable"."ConstituentPermit", "ConcessionsTable"."Geometry", "ConcessionsTable"."ProductType", "ConcessionsTable"."Company", "ConcessionsTable"."Approved", "ConcessionsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                         FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                         WHERE "ConcessionsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                         LIMIT 1) AS email, "ConcessionsTable"."CreatedAt", "ConcessionsTable"."UpdatedAt", "ConcessionsTable"."DeletedAt";


create view "ForestResources"."DevelopmentUnits"
            ("Id", "Name", "Concession", "Start", "End", "Geometry", "Approved", "Number", "User", "Email",
             "ProductType", "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT ct."Id",
       ct."Name",
       ct."Concession",
       ct."Start",
       ct."End",
       ct."Geometry",
       ct."Approved",
       ct."Number",
       ct."User",
       acc.email AS "Email",
       ct."ProductType",
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."DevelopmentUnitsTable" ct
         LEFT JOIN admin.accounts acc ON ct."User" = acc.id;

alter table "ForestResources"."DevelopmentUnits"
    owner to postgres;

CREATE RULE "DevelopmentUnits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."DevelopmentUnits" DO INSTEAD DELETE
                                                                 FROM "ForestResources"."DevelopmentUnitsTable"
                                                                 WHERE "DevelopmentUnitsTable"."Id" = old."Id";

CREATE RULE "DevelopmentUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentUnits" DO INSTEAD INSERT INTO "ForestResources"."DevelopmentUnitsTable" ("Id",
                                                                                                                        "ResourceType",
                                                                                                                        "Name",
                                                                                                                        "Concession",
                                                                                                                        "Start",
                                                                                                                        "End",
                                                                                                                        "Geometry",
                                                                                                                        "Approved",
                                                                                                                        "Number",
                                                                                                                        "User",
                                                                                                                        "ProductType",
                                                                                                                        "CreatedAt",
                                                                                                                        "UpdatedAt")
                                                                 VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                         (SELECT rt."Id"
                                                                          FROM "ForestResources"."ResourceTypes" rt
                                                                          WHERE rt."Name" = 'Development Unit'::text
                                                                          LIMIT 1), new."Name", new."Concession",
                                                                         new."Start", new."End", new."Geometry",
                                                                         new."Approved", new."Number", new."User",
                                                                         new."ProductType", new."CreatedAt",
                                                                         new."UpdatedAt")
                                                                 RETURNING "DevelopmentUnitsTable"."Id", "DevelopmentUnitsTable"."Name", "DevelopmentUnitsTable"."Concession", "DevelopmentUnitsTable"."Start", "DevelopmentUnitsTable"."End", "DevelopmentUnitsTable"."Geometry", "DevelopmentUnitsTable"."Approved", "DevelopmentUnitsTable"."Number", "DevelopmentUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                          FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                          WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                          LIMIT 1) AS email, "DevelopmentUnitsTable"."ProductType", "DevelopmentUnitsTable"."CreatedAt", "DevelopmentUnitsTable"."UpdatedAt", "DevelopmentUnitsTable"."DeletedAt";

CREATE RULE "DevelopmentUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentUnits" DO INSTEAD UPDATE "ForestResources"."DevelopmentUnitsTable"
                                                                 SET "Name"        = new."Name",
                                                                     "Concession"  = new."Concession",
                                                                     "Start"       = new."Start",
                                                                     "End"         = new."End",
                                                                     "Geometry"    = new."Geometry",
                                                                     "Approved"    = new."Approved",
                                                                     "Number"      = new."Number",
                                                                     "User"        = new."User",
                                                                     "ProductType" = new."ProductType",
                                                                     "UpdatedAt"   = new."UpdatedAt",
                                                                     "DeletedAt"   = new."DeletedAt"
                                                                 WHERE "DevelopmentUnitsTable"."Id" = old."Id"
                                                                 RETURNING "DevelopmentUnitsTable"."Id", "DevelopmentUnitsTable"."Name", "DevelopmentUnitsTable"."Concession", "DevelopmentUnitsTable"."Start", "DevelopmentUnitsTable"."End", "DevelopmentUnitsTable"."Geometry", "DevelopmentUnitsTable"."Approved", "DevelopmentUnitsTable"."Number", "DevelopmentUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                                                                                          FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                                                                                          WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                                                                                          LIMIT 1) AS email, "DevelopmentUnitsTable"."ProductType", "DevelopmentUnitsTable"."CreatedAt", "DevelopmentUnitsTable"."UpdatedAt", "DevelopmentUnitsTable"."DeletedAt";


create view "ForestResources"."ManagementUnits"
            ("Id", "Name", "DevelopmentUnit", "Geometry", "Approved", "Number", "User", "Email", "ProductType",
             "CreatedAt", "UpdatedAt", "DeletedAt")
as
SELECT mut."Id",
       mut."Name",
       mut."DevelopmentUnit",
       mut."Geometry",
       mut."Approved",
       mut."Number",
       mut."User",
       acc.email AS "Email",
       mut."ProductType",
       mut."CreatedAt",
       mut."UpdatedAt",
       mut."DeletedAt"
FROM "ForestResources"."ManagementUnitsTable" mut
         LEFT JOIN admin.accounts acc ON acc.id = mut."User";

alter table "ForestResources"."ManagementUnits"
    owner to postgres;

CREATE RULE "ManagementUnits_instead_of_delete" AS
    ON DELETE TO "ForestResources"."ManagementUnits" DO INSTEAD DELETE
                                                                FROM "ForestResources"."ManagementUnitsTable"
                                                                WHERE "ManagementUnitsTable"."Id" = old."Id";

CREATE RULE "ManagementUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementUnits" DO INSTEAD INSERT INTO "ForestResources"."ManagementUnitsTable" ("Id",
                                                                                                                      "ResourceType",
                                                                                                                      "Name",
                                                                                                                      "DevelopmentUnit",
                                                                                                                      "Geometry",
                                                                                                                      "Approved",
                                                                                                                      "Number",
                                                                                                                      "User",
                                                                                                                      "ProductType",
                                                                                                                      "CreatedAt",
                                                                                                                      "UpdatedAt")
                                                                VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                                                                        (SELECT rt."Id"
                                                                         FROM "ForestResources"."ResourceTypes" rt
                                                                         WHERE rt."Name" = 'Management Unit'::text
                                                                         LIMIT 1), new."Name", new."DevelopmentUnit",
                                                                        new."Geometry", new."Approved", new."Number",
                                                                        new."User", new."ProductType", new."CreatedAt",
                                                                        new."UpdatedAt")
                                                                RETURNING "ManagementUnitsTable"."Id", "ManagementUnitsTable"."Name", "ManagementUnitsTable"."DevelopmentUnit", "ManagementUnitsTable"."Geometry", "ManagementUnitsTable"."Approved", "ManagementUnitsTable"."Number", "ManagementUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                       FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                       WHERE "ManagementUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS email, "ManagementUnitsTable"."ProductType", "ManagementUnitsTable"."CreatedAt", "ManagementUnitsTable"."UpdatedAt", "ManagementUnitsTable"."DeletedAt";

CREATE RULE "ManagementUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ManagementUnits" DO INSTEAD UPDATE "ForestResources"."ManagementUnitsTable"
                                                                SET "Name"            = new."Name",
                                                                    "DevelopmentUnit" = new."DevelopmentUnit",
                                                                    "Geometry"        = new."Geometry",
                                                                    "Approved"        = new."Approved",
                                                                    "Number"          = new."Number",
                                                                    "User"            = new."User",
                                                                    "ProductType"     = new."ProductType",
                                                                    "UpdatedAt"       = new."UpdatedAt",
                                                                    "DeletedAt"       = new."DeletedAt"
                                                                WHERE "ManagementUnitsTable"."Id" = old."Id"
                                                                RETURNING "ManagementUnitsTable"."Id", "ManagementUnitsTable"."Name", "ManagementUnitsTable"."DevelopmentUnit", "ManagementUnitsTable"."Geometry", "ManagementUnitsTable"."Approved", "ManagementUnitsTable"."Number", "ManagementUnitsTable"."User", (SELECT acc.email
                                                                                                                                                                                                                                                                                                                       FROM admin.accounts acc
                                                                                                                                                                                                                                                                                                                       WHERE "ManagementUnitsTable"."User" = acc.id
                                                                                                                                                                                                                                                                                                                       LIMIT 1) AS email, "ManagementUnitsTable"."ProductType", "ManagementUnitsTable"."CreatedAt", "ManagementUnitsTable"."UpdatedAt", "ManagementUnitsTable"."DeletedAt";




create view "ForestResources"."Parcels"
            ("Id", "Name", "Geometry", "Approved", "User", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT pt."Id",
       pt."Name",
       pt."Geometry",
       pt."Approved",
       pt."User",
       pt."CreatedAt",
       pt."UpdatedAt",
       pt."DeletedAt"
FROM "ForestResources"."ParcelsTable" pt;

comment on view "ForestResources"."Parcels" is 'Parcels';

alter table "ForestResources"."Parcels"
    owner to postgres;

CREATE RULE "Parcels_instead_of_delete" AS
    ON DELETE TO "ForestResources"."Parcels" DO INSTEAD DELETE
                                                        FROM "ForestResources"."ParcelsTable"
                                                        WHERE "ParcelsTable"."Id" = old."Id";

CREATE RULE "Parcels_instead_of_insert" AS
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
                                                        RETURNING "ParcelsTable"."Id", "ParcelsTable"."Name", "ParcelsTable"."Geometry", "ParcelsTable"."Approved", "ParcelsTable"."User", "ParcelsTable"."CreatedAt", "ParcelsTable"."UpdatedAt", "ParcelsTable"."DeletedAt";

CREATE RULE "Parcels_instead_of_update" AS
    ON UPDATE TO "ForestResources"."Parcels" DO INSTEAD UPDATE "ForestResources"."ParcelsTable"
                                                        SET "Name"      = new."Name",
                                                            "Geometry"  = new."Geometry",
                                                            "Approved"  = new."Approved",
                                                            "UpdatedAt" = new."UpdatedAt",
                                                            "DeletedAt" = new."DeletedAt"
                                                        WHERE "ParcelsTable"."Id" = old."Id"
                                                        RETURNING "ParcelsTable"."Id", "ParcelsTable"."Name", "ParcelsTable"."Geometry", "ParcelsTable"."Approved", "ParcelsTable"."User", "ParcelsTable"."CreatedAt", "ParcelsTable"."UpdatedAt", "ParcelsTable"."DeletedAt";







create view "ForestResources"."ConstituentPermits"
            ("Id", "User", "Email", "PermitType", "PermitNumber", "Geometry", "Approved", "CreatedAt", "UpdatedAt",
             "DeletedAt") as
SELECT cpt."Id",
       cpt."User",
       acc.email AS "Email",
       cpt."PermitType",
       cpt."PermitNumber",
       cpt."Geometry",
       cpt."Approved",
       cpt."CreatedAt",
       cpt."UpdatedAt",
       cpt."DeletedAt"
FROM "ForestResources"."ConstituentPermitsTable" cpt,
     admin.accounts acc
WHERE cpt."User" = acc.id;

alter table "ForestResources"."ConstituentPermits"
    owner to postgres;

CREATE RULE "ConstituentPermits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ConstituentPermits" DO INSTEAD INSERT INTO "ForestResources"."ConstituentPermitsTable" ("Id",
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
                                                                   RETURNING "ConstituentPermitsTable"."Id", "ConstituentPermitsTable"."User", (SELECT acc.email
                                                                                                                                                FROM admin.accounts acc
                                                                                                                                                WHERE "ConstituentPermitsTable"."User" = acc.id) AS email, "ConstituentPermitsTable"."PermitType", "ConstituentPermitsTable"."PermitNumber", "ConstituentPermitsTable"."Geometry", "ConstituentPermitsTable"."Approved", "ConstituentPermitsTable"."CreatedAt", "ConstituentPermitsTable"."UpdatedAt", "ConstituentPermitsTable"."DeletedAt";

CREATE RULE "ConstituentPermits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ConstituentPermits" DO INSTEAD UPDATE "ForestResources"."ConstituentPermitsTable"
                                                                   SET "User"         = new."User",
                                                                       "PermitType"   = new."PermitType",
                                                                       "PermitNumber" = new."PermitNumber",
                                                                       "Geometry"     = new."Geometry",
                                                                       "Approved"     = new."Approved",
                                                                       "UpdatedAt"    = new."UpdatedAt",
                                                                       "DeletedAt"    = new."DeletedAt"
                                                                   WHERE "ConstituentPermitsTable"."Id" = old."Id"
                                                                   RETURNING "ConstituentPermitsTable"."Id", "ConstituentPermitsTable"."User", (SELECT acc.email
                                                                                                                                                FROM admin.accounts acc
                                                                                                                                                WHERE "ConstituentPermitsTable"."User" = acc.id) AS email, "ConstituentPermitsTable"."PermitType", "ConstituentPermitsTable"."PermitNumber", "ConstituentPermitsTable"."Geometry", "ConstituentPermitsTable"."Approved", "ConstituentPermitsTable"."CreatedAt", "ConstituentPermitsTable"."UpdatedAt", "ConstituentPermitsTable"."DeletedAt";

