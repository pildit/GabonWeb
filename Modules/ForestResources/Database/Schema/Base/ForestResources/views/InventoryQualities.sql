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
