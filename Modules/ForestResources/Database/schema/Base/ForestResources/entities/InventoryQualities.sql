create table "ForestResources"."InventoryQualitiesTable"
(
    "Id" int not null,
    "Description" text null,
    "Value" int not null,
    constraint "PK_ForestResources.InventoryQualitiesTable" primary key("Id"),
    constraint "CHK_ForestResources.InventoryQualitiesTable.Description" check ("Description" is null or length("Description") > 0),
    constraint "UNIQ_ForestResources.InventoryQualitiesTable.Description" unique("Description"),
    constraint "UNIQ_ForestResources.InventoryQualitiesTable.Value" unique("Value")
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


----------
-- VIEW --
----------
create view "ForestResources"."InventoryQualities"
as
    select
        iqt."Id"
        , iqt."Description"
        , iqt."Value"
    from "ForestResources"."InventoryQualitiesTable" as iqt
;

-----------
-- RULES --
-----------
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
            )
        values
            (
                nextval('"ForestResources"."SEQ_InventoryQualities"')
                , new."Description"
                , new."Value"
            )
        returning
            "Id"
            , "Description"
            , "Value"
;

create or replace rule "InventoryQualities_instead_of_update"
as
    on update to "ForestResources"."InventoryQualities"
    do instead
        update "ForestResources"."InventoryQualitiesTable"
            set
                "Description" = new."Description"
                , "Value" = new."Value"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "Description"
                , "Value"
;
