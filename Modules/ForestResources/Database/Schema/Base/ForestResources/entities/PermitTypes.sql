create table "ForestResources"."PermitTypesTable"
(
    "Id" int not null,
    "Name" text,
    "Abbreviation" text not null,
    "UserId"       integer,
    constraint "PK_ForestResources.PermitTypesTable" primary key("Id"),
    constraint "CHK_ForestResources.PermitTypesTable.Abbreviation" check (length("Abbreviation") > 0),
    constraint "UNIQ_ForestResources.PermitTypesTable.Name" unique("Name"),
    constraint "UNIQ_ForestResources.PermitTypesTable.Abbreviation" unique("Abbreviation")
);

create sequence if not exists "ForestResources"."SEQ_PermitTypes"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."PermitTypesTable"."Id"
;



create unique index "UX_PermitTypesTable.Name"
on "ForestResources"."PermitTypesTable"
    (
        "Name"
    )
;

create unique index "UX_PermitTypesTable.Abbreviation"
on "ForestResources"."PermitTypesTable"
    (
        "Abbreviation"
    )
;

create view "PermitTypes"("Id", "Name", "Abbreviation", "UserId", "CreatedAt", "UpdatedAt") as
SELECT pt."Id",
       pt."Name",
       pt."Abbreviation",
       pt."UserId",
       pt."CreatedAt",
       pt."UpdatedAt"
FROM "ForestResources"."PermitTypesTable" pt;

CREATE RULE "PermitTypes_instead_of_insert" AS
    ON INSERT TO "ForestResources"."PermitTypes" DO INSTEAD  INSERT INTO "ForestResources"."PermitTypesTable" ("Id", "Name", "Abbreviation", "UserId", "CreatedAt", "UpdatedAt")
  VALUES (nextval('"ForestResources"."SEQ_PermitTypes"'::regclass), new."Name", new."Abbreviation", new."UserId", new."CreatedAt", new."UpdatedAt")
  RETURNING "PermitTypesTable"."Id",
    "PermitTypesTable"."Name",
    "PermitTypesTable"."Abbreviation",
    "PermitTypesTable"."UserId",
    "PermitTypesTable"."CreatedAt",
    "PermitTypesTable"."UpdatedAt";




CREATE RULE "PermitTypes_instead_of_update" AS
    ON UPDATE TO "ForestResources"."PermitTypes" DO INSTEAD  UPDATE "ForestResources"."PermitTypesTable" SET "Name" = new."Name", "Abbreviation" = new."Abbreviation"
  WHERE "PermitTypesTable"."Id" = old."Id"
  RETURNING "PermitTypesTable"."Id",
    "PermitTypesTable"."Name",
    "PermitTypesTable"."Abbreviation",
        "PermitTypesTable"."UserId",
    "PermitTypesTable"."CreatedAt",
    "PermitTypesTable"."UpdatedAt";



CREATE RULE "PermitTypes_instead_of_delete" AS
    ON DELETE TO "ForestResources"."PermitTypes" DO INSTEAD  DELETE FROM "ForestResources"."PermitTypesTable"
  WHERE "PermitTypesTable"."Id" = old."Id";


