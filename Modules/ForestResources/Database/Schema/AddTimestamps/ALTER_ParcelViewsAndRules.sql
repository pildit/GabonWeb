create or replace view "ForestResources"."Parcels"
as
    select
        pt."Id"
        , pt."Name"
        , pt."Geometry"
        , pt."CreatedAt"
        , pt."UpdatedAt"
        , pt."DeletedAt"
    from "ForestResources"."ParcelsTable" as pt
;

-----------
-- RULES --
-----------

create or replace rule "Parcels_instead_of_insert"
as
    on insert to "ForestResources"."Parcels"
    do instead
        insert into "ForestResources"."ParcelsTable"
            (
                "Id"
                ,"ResourceType"
                ,"Name"
                ,"Geometry"
                ,"CreatedAt"
                ,"UpdatedAt"
            )
        values
            (
                nextval('"ForestResources"."SEQ_BaseResources"')
                ,(
                    select rt."Id"
                    from "ForestResources"."ResourceTypes" as rt
                    where rt."Name" = 'Parcel'
                    limit 1)
                , new."Name"
                , new."Geometry"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id",
            "Name",
            "Geometry",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "Parcels_instead_of_update"
as
    on update to "ForestResources"."Parcels"
    do instead
        update "ForestResources"."ParcelsTable"
            set
                "Name" = new."Name"
                , "Geometry" = new."Geometry"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Geometry",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;

