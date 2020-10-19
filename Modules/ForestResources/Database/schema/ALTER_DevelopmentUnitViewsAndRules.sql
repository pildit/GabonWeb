----------
-- VIEW --
----------
create or replace view "ForestResources"."DevelopmentUnits"
as
    select
        ct."Id"
        , ct."Name"
        , ct."Concession"
        , ct."Start"
        , ct."End"
        , ct."Geometry"
        , ct."CreatedAt"
        , ct."UpdatedAt"
        , ct."DeletedAt"
    from "ForestResources"."DevelopmentUnitsTable" as ct
;

-----------
-- RULES --
-----------
create or replace rule "DevelopmentUnits_instead_of_insert"
as
    on insert to "ForestResources"."DevelopmentUnits"
    do instead
        insert into "ForestResources"."DevelopmentUnitsTable"
            (
                "Id",
                "ResourceType",
                "Name",
                "Concession",
                "Start",
                "End",
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
                    where rt."Name" = 'Development Unit'
                    limit 1)
                , new."Name"
                , new."Concession"
                , new."Start"
                , new."End"
                , new."Geometry"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id",
            "Name",
            "Concession",
            "Start",
            "End",
            "Geometry",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "DevelopmentUnits_instead_of_update"
as
    on update to "ForestResources"."DevelopmentUnits"
    do instead
        update "ForestResources"."DevelopmentUnitsTable"
            set
                "Name" = new."Name"
                , "Concession" = new."Concession"
                , "Start" = new."Start"
                , "End" = new."End"
                , "Geometry" = new."Geometry"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Concession",
                "Start",
                "End",
                "Geometry",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;

