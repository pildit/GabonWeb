----------
-- VIEW --
----------
create view "ForestResources"."PermitTypes"
as
    select
        pt."Id"
        , pt."Name"
        , pt."Abbreviation"
    from "ForestResources"."PermitTypesTable" as pt
;

-----------
-- RULES --
-----------
create or replace rule "PermitTypes_instead_of_delete"
as
    on delete to "ForestResources"."PermitTypes"
    do instead
        delete from "ForestResources"."PermitTypesTable"
        where
            "ForestResources"."PermitTypesTable"."Id" = old."Id"
;

create or replace rule "PermitTypes_instead_of_insert"
as
    on insert to "ForestResources"."PermitTypes"
    do instead
        insert into "ForestResources"."PermitTypesTable"
            (
                "Id"
                , "Name"
                , "Abbreviation"
            )
        values
            (
                nextval('"ForestResources"."SEQ_PermitTypes"')
                , new."Name"
                , new."Abbreviation"
            )
        returning
            "Id"
            , "Name"
            , "Abbreviation"
;

create or replace rule "PermitTypes_instead_of_update"
as
    on update to "ForestResources"."PermitTypes"
    do instead
        update "ForestResources"."PermitTypesTable"
            set
                "Name" = new."Name"
                , "Abbreviation" = new."Abbreviation"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "Name"
                , "Abbreviation"
;
