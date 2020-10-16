create table "ForestResources"."ConstituentPermitsTable"
(
    "Id" int not null,
    "User" int not null,
    "PermitType" int not null,
    "PermitNumber" text not null,
    "Geometry" geometry not null,
    constraint "PK_ConstituentPermitsTable" primary key("Id"),
    constraint "CHK_ConstituentPermitsTable_PermitNumber" check (length("PermitNumber") > 0)
)
;


create sequence if not exists "ForestResources"."SEQ_ConstituentPermits"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."ConstituentPermitsTable"."Id"
;


create index "IX_ConstituentPermitsTable.Name"
on "ForestResources"."ConstituentPermitsTable"
    (
        "User"
    )
;


create index "IX_ConstituentPermitsTable.PermitType"
on "ForestResources"."ConstituentPermitsTable"
    (
        "PermitType"
    )
;


----------
-- VIEW --
----------
create view "ForestResources"."ConstituentPermits"
as
    select
        cpt."Id"
        , cpt."User"
        , cpt."PermitType"
        , cpt."PermitNumber"
        , cpt."Geometry"
    from "ForestResources"."ConstituentPermitsTable" as cpt
;

-----------
-- RULES --
-----------
create or replace rule "ConstituentPermits_instead_of_delete"
as
    on delete to "ForestResources"."ConstituentPermits"
    do instead
        delete from "ForestResources"."ConstituentPermitsTable"
        where
            "ForestResources"."ConstituentPermitsTable"."Id" = old."Id"
;

create or replace rule "ConstituentPermits_instead_of_insert"
as
    on insert to "ForestResources"."ConstituentPermits"
    do instead
        insert into "ForestResources"."ConstituentPermitsTable"
            (
                "Id"
                , "User"
                , "PermitType"
                , "PermitNumber"
                , "Geometry"
            )
        values
            (
                nextval('"ForestResources"."SEQ_ConstituentPermits"')
                , new."User"
                , new."PermitType"
                , new."PermitNumber"
                , new."Geometry"
            )
        returning
            "Id"
            , "User"
            , "PermitType"
            , "PermitNumber"
            , "Geometry"
;

create or replace rule "ConstituentPermits_instead_of_update"
as
    on update to "ForestResources"."ConstituentPermits"
    do instead
        update "ForestResources"."ConstituentPermitsTable"
            set
                "User" = new."User"
                , "PermitType" = new."PermitType"
                , "PermitNumber" = new."PermitNumber"
                , "Geometry" = new."Geometry"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "User"
                , "PermitType"
                , "PermitNumber"
                , "Geometry"
;
