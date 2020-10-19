-------------------------------------
-- "ForestResources"."Concessions" --
-------------------------------------
create table "ForestResources"."ConcessionsTable"
(
    "Continent" text not null,
    "ConstituentPermit" int not null,
    constraint "CHK_ConcessionsTable.Continent" check (length("Continent") > 0),
    constraint "PK_ConcessionsTable" primary key("Id"),
    constraint "UNIQ_ConcessionsTable_ConstituentPermit" unique ("ConstituentPermit")
)
inherits ("ForestResources"."BaseResourcesTable")
;

comment on table "ForestResources"."ConcessionsTable"
    is 'Concessions';

-- If you query by name, you are likely to filter by continent as well, not just name
create index "IX_ConcessionsTable.Name_Continent"
on "ForestResources"."ConcessionsTable"
    (
        "Name"
        , "Continent"
    )
;

create index "IX_ConcessionsTable.Continent"
on "ForestResources"."ConcessionsTable"
    (
        "Continent"
    )
;

create index "IX_ConcessionsTable.ConstituentPermit"
on "ForestResources"."ConcessionsTable"
    (
        "ConstituentPermit"
    )
;

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
