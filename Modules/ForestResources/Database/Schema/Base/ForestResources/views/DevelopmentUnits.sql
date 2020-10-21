----------
-- VIEW --
----------
create view "ForestResources"."DevelopmentUnits"
as
    select
        ct."Id"
        , ct."Name"
        , ct."Concession"
        , ct."Start"
        , ct."End"
        , ct."Geometry"
    from "ForestResources"."DevelopmentUnitsTable" as ct
;

comment on view "ForestResources"."DevelopmentUnits"
    is 'Unite Forestiere d''Amenagement (UFA)';

-----------
-- RULES --
-----------
create or replace rule "DevelopmentUnits_instead_of_delete"
as
    on delete to "ForestResources"."DevelopmentUnits"
    do instead
        delete from "ForestResources"."DevelopmentUnitsTable"
        where
            "ForestResources"."DevelopmentUnitsTable"."Id" = old."Id"
;

create or replace rule "DevelopmentUnits_instead_of_insert"
as
    on insert to "ForestResources"."DevelopmentUnits"
    do instead
        insert into "ForestResources"."DevelopmentUnitsTable"
            ("Id","ResourceType", "Name", "Concession","Start","End","Geometry")
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
            )
        returning
            "Id",
            "Name",
            "Concession",
            "Start",
            "End",
            "Geometry"
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
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Concession",
                "Start",
                "End",
                "Geometry"
;
