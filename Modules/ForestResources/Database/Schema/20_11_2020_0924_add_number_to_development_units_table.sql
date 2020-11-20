alter table "ForestResources"."DevelopmentUnitsTable"
    add "Number" varchar not null default '';

alter table "ForestResources"."DevelopmentUnitsTable"
    add "User" int;

alter table "ForestResources"."DevelopmentUnitsTable"
    add constraint developmentunitstable_accounts_id_fk
        foreign key ("User") references admin.accounts;


drop view "ForestResources"."DevelopmentUnits"
create view "ForestResources"."DevelopmentUnits"
            ("Id", "Name", "Concession", "Start", "End", "Geometry", "Approved", "Number", "User", "Email", "CreatedAt", "UpdatedAt",
             "DeletedAt") as
SELECT ct."Id",
       ct."Name",
       ct."Concession",
       ct."Start",
       ct."End",
       ct."Geometry",
       ct."Approved",
       ct."Number",
       ct."User",
       acc."email" as Email,
       ct."CreatedAt",
       ct."UpdatedAt",
       ct."DeletedAt"
FROM "ForestResources"."DevelopmentUnitsTable" ct left JOIN admin.accounts acc on ct."User" = acc.id;

CREATE RULE "DevelopmentUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."DevelopmentUnits"
    DO INSTEAD INSERT INTO "ForestResources"."DevelopmentUnitsTable" (
         "Id",
         "ResourceType",
         "Name",
         "Concession",
         "Start",
         "End",
         "Geometry",
         "Approved",
         "Number",
         "User",
         "CreatedAt",
         "UpdatedAt")
         VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                 (SELECT rt."Id"
                  FROM "ForestResources"."ResourceTypes" rt
                  WHERE rt."Name" = 'Development Unit'::text
                  LIMIT 1), new."Name", new."Concession",
                 new."Start", new."End", new."Geometry",
                 new."Approved", new."Number", new."User", new."CreatedAt",
                 new."UpdatedAt")
         RETURNING "Id",
             "Name",
             "Concession",
             "Start",
             "End",
             "Geometry",
             "Approved",
             "Number",
             "User",
             (select acc.email from admin.accounts acc where "ForestResources"."DevelopmentUnitsTable"."User" = acc.id limit 1 ) as Email,
             "CreatedAt",
             "UpdatedAt",
             "DeletedAt";

CREATE RULE "DevelopmentUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."DevelopmentUnits"
    DO INSTEAD UPDATE "ForestResources"."DevelopmentUnitsTable"
         SET "Name"       = new."Name",
             "Concession" = new."Concession",
             "Start"      = new."Start",
             "End"        = new."End",
             "Geometry"   = new."Geometry",
             "Approved"   = new."Approved",
             "Number"     = new."Number",
             "User"       = new."User",
             "UpdatedAt"  = new."UpdatedAt",
             "DeletedAt"  = new."DeletedAt"
         WHERE "DevelopmentUnitsTable"."Id" = old."Id"
               RETURNING "Id",
                   "Name",
                   "Concession",
                   "Start",
                   "End",
                   "Geometry",
                   "Approved",
                   "Number",
                   "User",
                   (select acc.email from admin.accounts acc where "ForestResources"."DevelopmentUnitsTable"."User" = acc.id limit 1 ) as Email,
                   "CreatedAt",
                   "UpdatedAt",
                   "DeletedAt";

