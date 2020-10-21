----------
-- VIEW --
----------
create or replace view "ForestResources"."ManagementUnits"
as
    select
        mut."Id"
        , mut."Name"
        , mut."DevelopmentUnit"
        , mut."Geometry"
        , mut."CreatedAt"
        , mut."UpdatedAt"
        , mut."DeletedAt"
    from "ForestResources"."ManagementUnitsTable" as mut
;

-----------
-- RULES --
-----------
create or replace rule "ManagementUnits_instead_of_insert"
as
    on insert to "ForestResources"."ManagementUnits"
    do instead
        insert into "ForestResources"."ManagementUnitsTable"
            (
                "Id",
                "ResourceType",
                "Name",
                "DevelopmentUnit",
                "Geometry",
                "CreatedAt",
                "UpdatedAt"
            )
        values
            (
                nextval('"ForestResources"."SEQ_BaseResources"')
                ,(
                    select rt."Id"
                    from "ForestResources"."ResourceTypes" as rt
                    where rt."Name" = 'Management Unit'
                    limit 1)
                , new."Name"
                , new."DevelopmentUnit"
                , new."Geometry"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id",
            "Name",
            "DevelopmentUnit",
            "Geometry",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "ManagementUnits_instead_of_update"
as
    on update to "ForestResources"."ManagementUnits"
    do instead
        update "ForestResources"."ManagementUnitsTable"
            set
                "Name" = new."Name"
                , "DevelopmentUnit" = new."DevelopmentUnit"
                , "Geometry" = new."Geometry"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "DevelopmentUnit",
                "Geometry",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;
