----------
-- VIEW --
----------
create or replace view "ForestResources"."InventoryQualities"
as
    select
        iqt."Id"
        , iqt."Description"
        , iqt."Value",
        iqt."User",
        acc.email AS "Email",
        iqt."CreatedAt",
        iqt."UpdatedAt",
        iqt."DeletedAt"
    from "ForestResources"."InventoryQualitiesTable" as iqt
    left join admin.accounts acc on acc.id = iqt."User";
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
                , "CreatedAt"
                , "User"
            )
        values
            (
                nextval('"ForestResources"."SEQ_InventoryQualities"')
                , new."Description"
                , new."Value"
                , new."CreatedAt"
                , new."User"
            )
        returning
            "Id"
            , "Description"
            , "Value"
            , "User"
            , (select acc.email from admin.accounts acc where "InventoryQualitiesTable"."User" = acc.id LIMIT 1)
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
            , "User"
            , (select acc.email from admin.accounts acc where "InventoryQualitiesTable"."User" = acc.id LIMIT 1)
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
;
