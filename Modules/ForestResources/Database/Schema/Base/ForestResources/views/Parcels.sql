create table "ParcelsTable"
(
    "Approved" boolean default false,
    "User"     integer,
    constraint "PK_ParcelsTable"
        primary key ("Id"),
    constraint "CHK_BaseResourcesTable.Name"
        check (length("Name") > 0)
)
    inherits ("BaseResourcesTable");

----------
-- VIEW --
----------
create or replace view "ForestResources"."Parcels"
as
    select
        pt."Id"
        , pt."Name"
        , pt."Geometry"
        , pt."Approved"
        , pt."User"
        , pt."CreatedAt"
        , pt."UpdatedAt"
        , pt."DeletedAt"
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
                ,"CreatedAt"
                ,"Approved"
                ,"User"
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
                , new."Approved"
                , new."User"
            )
        returning
            "Id",
            "Name",
            "Geometry",
            "Approved",
            "User",
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
                , "Approved" = new."Approved"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Geometry",
                "Approved",
                "User",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;
