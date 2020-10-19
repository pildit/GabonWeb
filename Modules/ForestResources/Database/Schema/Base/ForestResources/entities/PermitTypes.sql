create table "ForestResources"."PermitTypesTable"
(
    "Id" int not null,
    "Name" text not null,
    "Abbreviation" text not null,
    constraint "PK_ForestResources.PermitTypesTable" primary key("Id"),
    constraint "CHK_ForestResources.PermitTypesTable.Name" check (length("Name") > 0),
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
