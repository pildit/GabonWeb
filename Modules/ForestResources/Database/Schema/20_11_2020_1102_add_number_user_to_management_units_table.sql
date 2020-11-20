alter table "ForestResources"."ManagementUnitsTable"
    add "Number" varchar not null default '';

alter table "ForestResources"."ManagementUnitsTable"
    add "User" int;

alter table "ForestResources"."ManagementUnitsTable"
    add constraint managementunitstable_accounts_id_fk
        foreign key ("User") references admin.accounts;

drop view "ForestResources"."ManagementUnits"
create view "ForestResources"."ManagementUnits"
            ("Id", "Name", "DevelopmentUnit", "Geometry", "Approved", "Number", "User", "Email", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT mut."Id",
       mut."Name",
       mut."DevelopmentUnit",
       mut."Geometry",
       mut."Approved",
       mut."Number",
       mut."User",
       acc."email" as Email,
       mut."CreatedAt",
       mut."UpdatedAt",
       mut."DeletedAt"
FROM "ForestResources"."ManagementUnitsTable" mut Left Join admin.accounts acc on acc.id = mut."User"

CREATE RULE "ManagementUnits_instead_of_insert" AS
    ON INSERT TO "ForestResources"."ManagementUnits"
    DO INSTEAD INSERT INTO "ForestResources"."ManagementUnitsTable" (
          "Id",
          "ResourceType",
          "Name",
          "DevelopmentUnit",
          "Geometry",
          "Approved",
          "Number",
          "User",
          "CreatedAt",
          "UpdatedAt")
        VALUES (nextval('"ForestResources"."SEQ_BaseResources"'::regclass),
                (SELECT rt."Id"
                 FROM "ForestResources"."ResourceTypes" rt
                 WHERE rt."Name" = 'Management Unit'::text
                 LIMIT 1), new."Name", new."DevelopmentUnit",
                new."Geometry", new."Approved", new."Number", new."User", new."CreatedAt",
                new."UpdatedAt")
        RETURNING
            "Id",
            "Name",
            "DevelopmentUnit",
            "Geometry",
            "Approved",
            "Number",
            "User",
            (select acc.email from admin.accounts acc where "ForestResources"."ManagementUnitsTable"."User" = acc.id limit 1 ) as Email,
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt";

CREATE RULE "ManagementUnits_instead_of_update" AS
    ON UPDATE TO "ForestResources"."ManagementUnits"
    DO INSTEAD UPDATE "ForestResources"."ManagementUnitsTable"
            SET "Name"            = new."Name",
                "DevelopmentUnit" = new."DevelopmentUnit",
                "Geometry"        = new."Geometry",
                "Approved"        = new."Approved",
                "Approved"        = new."Approved",
                "Number"          = new."Number",
                "User"            = new."User",
                "UpdatedAt"       = new."UpdatedAt",
                "DeletedAt"       = new."DeletedAt"
            WHERE "ManagementUnitsTable"."Id" = old."Id"
            RETURNING
               "Id",
               "Name",
               "DevelopmentUnit",
               "Geometry",
               "Approved",
               "Number",
               "User",
               (select acc.email from admin.accounts acc where "ForestResources"."ManagementUnitsTable"."User" = acc.id limit 1 ) as Email,
               "CreatedAt",
               "UpdatedAt",
               "DeletedAt";

