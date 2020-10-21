----------
-- VIEW --
----------
create view "ForestResources"."Concessions"
as
    select
        ct."Id"
        , ct."Name"
        , ct."Continent"
        , ct."ConstituentPermit"
        , ct."Geometry"
    from "ForestResources"."ConcessionsTable" as ct
;

comment on view "ForestResources"."Concessions"
    is 'Concessions';

-----------
-- RULES --
-----------
create or replace rule "Concessions_instead_of_delete"
as
    on delete to "ForestResources"."Concessions"
    do instead
        delete from "ForestResources"."ConcessionsTable"
        where
            "ForestResources"."ConcessionsTable"."Id" = old."Id"
;

create or replace rule "Concessions_instead_of_insert"
as
    on insert to "ForestResources"."Concessions"
    do instead
        insert into "ForestResources"."ConcessionsTable"
            ("Id","ResourceType", "Name", "Continent", "ConstituentPermit", "Geometry")
        values
            (
                nextval('"ForestResources"."SEQ_BaseResources"')
                ,(
                    select rt."Id"
                    from "ForestResources"."ResourceTypes" as rt
                    where rt."Name" = 'Concession'
                    limit 1)
                , new."Name"
                , new."Continent"
                , new."ConstituentPermit"
                , new."Geometry"
            )
        returning
            "Id",
            "Name",
            "Continent",
            "ConstituentPermit",
            "Geometry"
;

create or replace rule "Concessions_instead_of_update"
as
    on update to "ForestResources"."Concessions"
    do instead
        update "ForestResources"."ConcessionsTable"
            set
                "Name" = new."Name"
                , "Continent" = new."Continent"
                , "ConstituentPermit" = new."ConstituentPermit"
                , "Geometry" = new."Geometry"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Continent",
                "ConstituentPermit",
                "Geometry"
;
