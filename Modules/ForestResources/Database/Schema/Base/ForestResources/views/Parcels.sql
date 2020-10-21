----------
-- VIEW --
----------
create view "ForestResources"."Parcels"
as
    select
        pt."Id"
        , pt."Name"
        , pt."Geometry"
    from "ForestResources"."ParcelsTable" as pt
;

comment on view "ForestResources"."Parcels"
    is 'Parcels';

-----------
-- RULES --
-----------
create or replace rule "Parcels_instead_of_delete"
as
    on delete to "ForestResources"."Parcels"
    do instead
        delete from "ForestResources"."ParcelsTable"
        where
            "ForestResources"."ParcelsTable"."Id" = old."Id"
;

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
            )
        returning
            "Id",
            "Name",
            "Geometry"
;

create or replace rule "Parcels_instead_of_update"
as
    on update to "ForestResources"."Parcels"
    do instead
        update "ForestResources"."ParcelsTable"
            set
                "Name" = new."Name"
                , "Geometry" = new."Geometry"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Geometry"
;
