
create table "ForestResources"."InventoryQualitiesTable"
(
    "Id"          serial                              not null
        constraint "PK_ForestResources.InventoryQualitiesTable"
            primary key,
    "Description" text
        constraint "UNIQ_ForestResources.InventoryQualitiesTable.Description"
            unique
        constraint "CHK_ForestResources.InventoryQualitiesTable.Description"
            check (("Description" IS NULL) OR (length("Description") > 0)),
    "Value"       integer                             not null
        constraint "UNIQ_ForestResources.InventoryQualitiesTable.Value"
            unique,
    "UserId"      integer,
    "CreatedAt"   timestamp default CURRENT_TIMESTAMP not null,
    "UpdatedAt"   timestamp default CURRENT_TIMESTAMP not null,
    "DeletedAt"   timestamp
);

create sequence if not exists "ForestResources"."SEQ_InventoryQualities"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."InventoryQualitiesTable"."Id"
;



create unique index "UX_InventoryQualitiesTable.Description"
on "ForestResources"."InventoryQualitiesTable"
    (
        "Description"
    )
;

create unique index "UX_InventoryQualitiesTable.Value"
on "ForestResources"."InventoryQualitiesTable"
    (
        "Value"
    )
;

create view ForestResources."InventoryQualities" ("Id", "Description", "Value", "UserId", "CreatedAt", "UpdatedAt", "DeletedAt") as
SELECT iqt."Id",
       iqt."Description",
       iqt."Value",
       iqt."UserId",
       iqt."CreatedAt",
       iqt."UpdatedAt",
       iqt."DeletedAt"
FROM "ForestResources"."InventoryQualitiesTable" iqt;


create or replace rule "InventoryQualities_instead_of_delete"
as
    on delete to "ForestResources"."InventoryQualities"
    do instead
        delete from "ForestResources"."InventoryQualitiesTable"
        where
            "ForestResources"."InventoryQualitiesTable"."Id" = old."Id"
;

create or replace rule "InventoryQualities_instead_of_insert"
as
    on insert to "ForestResources"."InventoryQualities"
    do instead
        insert into "ForestResources"."InventoryQualitiesTable"
            (
                "Id"
                , "Description"
                , "Value"
                , "CreatedAt"
                , "UserId"
            )
        values
            (
                nextval('"ForestResources"."SEQ_InventoryQualities"')
                , new."Description"
                , new."Value"
                , new."CreatedAt"
                , new."UserId"
            )
        returning
            "Id"
            , "Description"
            , "Value"
            , "UserId"
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
;

create or replace rule "InventoryQualities_instead_of_update"
as
    on update to "ForestResources"."InventoryQualities"
    do instead
        update "ForestResources"."InventoryQualitiesTable"
            set
                "Description" = new."Description"
                , "Value" = new."Value"
                , "UpdatedAt" = new."UpdatedAt"
            where
                "Id" = old."Id"
            returning
            "Id"
            , "Description"
            , "Value"
            , "UserId"
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
;

