create table "Taxonomy"."SpeciesTable"
(
    "Id" int not null,
    "Code" text not null,
    "LatinName" text,
    "CommonName" text,
    "CreatedAt"   timestamp,
    "UpdatedAt"   timestamp,
    "DeletedAt"   timestamp,
    "UserId"      integer,
    constraint "PK_SpeciesTable" primary key ("Id"),
    constraint "CHK_SpeciesTable_Code" check (length("Code") > 0),
    constraint "CHK_SpeciesTable_LatinName" check (length("LatinName") > 0),
    constraint "CHK_SpeciesTable_CommonName" check (length("CommonName") > 0),
    constraint "UNIQ_SpeciesTable_Code" unique ("Code"),
    constraint "UNIQ_SpeciesTable_LatinName" unique ("LatinName")
)
;

create sequence if not exists "Taxonomy"."SEQ_Species"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "Taxonomy"."SpeciesTable"."Id"
;

create unique index "UX_SpeciesTable.Code_LatinName"
    on "Taxonomy"."SpeciesTable"
    (
        "Code",
        "LatinName"
    )
;
create unique index "UX_SpeciesTable.LatinName"
    on "Taxonomy"."SpeciesTable"
    (
        "LatinName"
    )
;

create OR REPLACE  view "Taxonomy"."Species"
as
    select
        st."Id"
        , st."Code"
        , st."LatinName"
        , st."CommonName"
        , st."UserId"
        , st."CreatedAt"
        , st."UpdatedAt"
        , st."DeletedAt"

    from
        "Taxonomy"."SpeciesTable" as st LEFT JOIN
            "admin".accounts acc
    ON st."UserId" = acc.id
;

create or replace rule "Species_instead_of_delete"
as
    on delete to "Taxonomy"."Species"
    do instead
        delete from "Taxonomy"."SpeciesTable"
        where
            "Taxonomy"."SpeciesTable"."Id" = old."Id"
;

create or replace rule "Species_instead_of_insert"
as
    on insert to "Taxonomy"."Species"
    do instead
        insert into "Taxonomy"."SpeciesTable"
            ("Id", "Code", "LatinName", "CommonName", "UserId", "CreatedAt")
        values
            (nextval('"Taxonomy"."SEQ_Species"'), new."Code", new."LatinName", new."CommonName", new."UserId", new."CreatedAt")
        returning
    "Id"
     , "Code"
     , "LatinName"
     , "CommonName"
     , "UserId"
     , "CreatedAt"
     , "UpdatedAt"
     , "DeletedAt"
;

create or replace rule "Species_instead_of_update"
as
    on update to "Taxonomy"."Species"
    do instead
        update "Taxonomy"."SpeciesTable"
            set
                "Code" = new."Code"
                , "LatinName" = new."LatinName"
                , "CommonName" = new."CommonName"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
            "Id",
            "Code",
            "LatinName",
            "CommonName",
            "UserId",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt";
;
