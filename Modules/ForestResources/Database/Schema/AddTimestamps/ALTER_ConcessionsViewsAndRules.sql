-- Concessions
create or replace view "ForestResources"."Concessions"
as
    select
        ct."Id"
        , ct."Name"
        , ct."Continent"
        , ct."ConstituentPermit"
        , ct."Geometry"
        , ct."CreatedAt"
        , ct."UpdatedAt"
        , ct."DeletedAt"
    from "ForestResources"."ConcessionsTable" as ct
;

create or replace rule "Concessions_instead_of_insert"
as
    on insert to "ForestResources"."Concessions"
    do instead
        insert into "ForestResources"."ConcessionsTable"
            (
                "Id",
                "ResourceType",
                "Name",
                "Continent",
                "ConstituentPermit",
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
                    where rt."Name" = 'Concession'
                    limit 1)
                , new."Name"
                , new."Continent"
                , new."ConstituentPermit"
                , new."Geometry"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id",
            "Name",
            "Continent",
            "ConstituentPermit",
            "Geometry",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
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
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "Continent",
                "ConstituentPermit",
                "Geometry",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;
