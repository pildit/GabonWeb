-- Constituent Permit
create or replace view "ForestResources"."ConstituentPermits"
as
    select
        cpt."Id"
        , cpt."User"
        , cpt."PermitType"
        , cpt."PermitNumber"
        , cpt."Geometry"
        , cpt."CreatedAt"
        , cpt."UpdatedAt"
        , cpt."DeletedAt"
    from "ForestResources"."ConstituentPermitsTable" as cpt
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
                , "CreatedAt"
                , "UpdatedAt"
            )
        values
            (
                nextval('"ForestResources"."SEQ_ConstituentPermits"')
                , new."User"
                , new."PermitType"
                , new."PermitNumber"
                , new."Geometry"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id"
            , "User"
            , "PermitType"
            , "PermitNumber"
            , "Geometry"
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
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
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "User"
                , "PermitType"
                , "PermitNumber"
                , "Geometry"
                , "CreatedAt"
                , "UpdatedAt"
                , "DeletedAt"
;

