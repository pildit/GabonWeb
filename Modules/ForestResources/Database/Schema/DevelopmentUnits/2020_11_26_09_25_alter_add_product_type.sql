alter table "ForestResources"."DevelopmentUnitsTable"
    add "ProductType" int default 1 not null;

drop view if exists "ForestResources"."DevelopmentUnits"

create or replace view "ForestResources"."DevelopmentUnits"
            ("Id", "Name", "Concession", "Start", "End", "Geometry", "Approved", "Number", "User", "Email", "ProductType", "CreatedAt",
             "UpdatedAt", "DeletedAt")
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
                                                                         new."ProductType", new."CreatedAt", new."UpdatedAt")
                                                                 RETURNING "DevelopmentUnitsTable"."Id",
                                                                     "DevelopmentUnitsTable"."Name",
                                                                     "DevelopmentUnitsTable"."Concession",
                                                                     "DevelopmentUnitsTable"."Start",
                                                                     "DevelopmentUnitsTable"."End",
                                                                     "DevelopmentUnitsTable"."Geometry",
                                                                     "DevelopmentUnitsTable"."Approved",
                                                                     "DevelopmentUnitsTable"."Number",
                                                                     "DevelopmentUnitsTable"."User",
                                                                     (SELECT acc.email
                                                                      FROM admin.accounts acc
                                                                      WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                      LIMIT 1) AS email,
                                                                     "DevelopmentUnitsTable"."ProductType",
                                                                     "DevelopmentUnitsTable"."CreatedAt",
                                                                     "DevelopmentUnitsTable"."UpdatedAt",
                                                                     "DevelopmentUnitsTable"."DeletedAt";

CREATE RULE "DevelopmentUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentUnits" DO INSTEAD UPDATE "ForestResources"."DevelopmentUnitsTable"
                                                                 SET "Name"       = new."Name",
                                                                     "Concession" = new."Concession",
                                                                     "Start"      = new."Start",
                                                                     "End"        = new."End",
                                                                     "Geometry"   = new."Geometry",
                                                                     "Approved"   = new."Approved",
                                                                     "Number"     = new."Number",
                                                                     "User"       = new."User",
                                                                     "ProductType" = new."ProductType",
                                                                     "UpdatedAt"  = new."UpdatedAt",
                                                                     "DeletedAt"  = new."DeletedAt"
                                                                 WHERE "DevelopmentUnitsTable"."Id" = old."Id"
                                                                 RETURNING "DevelopmentUnitsTable"."Id",
                                                                     "DevelopmentUnitsTable"."Name",
                                                                     "DevelopmentUnitsTable"."Concession",
                                                                     "DevelopmentUnitsTable"."Start",
                                                                     "DevelopmentUnitsTable"."End",
                                                                     "DevelopmentUnitsTable"."Geometry",
                                                                     "DevelopmentUnitsTable"."Approved",
                                                                     "DevelopmentUnitsTable"."Number",
                                                                     "DevelopmentUnitsTable"."User",
                                                                     (SELECT acc.email
                                                                      FROM admin.accounts acc
                                                                      WHERE "DevelopmentUnitsTable"."User" = acc.id
                                                                      LIMIT 1) AS email,
                                                                     "DevelopmentUnitsTable"."ProductType",
                                                                     "DevelopmentUnitsTable"."CreatedAt",
                                                                     "DevelopmentUnitsTable"."UpdatedAt",
                                                                     "DevelopmentUnitsTable"."DeletedAt";

create or replace rule "DevelopmentUnits_instead_of_delete"
    as
    on delete to "ForestResources"."DevelopmentUnits"
    do instead
    delete from "ForestResources"."DevelopmentUnitsTable"
    where
            "ForestResources"."DevelopmentUnitsTable"."Id" = old."Id"

