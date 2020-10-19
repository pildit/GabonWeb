----------
-- VIEW --
----------
create view "ForestResources"."ResourceTypes"
as
    select
        rtt."Id"
        , rtt."Name"
    from "ForestResources"."ResourceTypesTable" as rtt
;

-----------
-- RULES --
-----------
create or replace rule "ResourceTypes_instead_of_delete"
as
    on delete to "ForestResources"."ResourceTypes"
    do instead
        delete from "ForestResources"."ResourceTypesTable"
        where
            "ForestResources"."ResourceTypesTable"."Id" = old."Id"
;

create or replace rule "ResourceTypes_instead_of_insert"
as
    on insert to "ForestResources"."ResourceTypes"
    do instead
        insert into "ForestResources"."ResourceTypesTable"
            ("Id", "Name")
        values
            (nextval('"ForestResources"."SEQ_ResourceTypes"'), new."Name")
        returning
            "Id",
            "Name"
;

create or replace rule "ResourceTypes_instead_of_update"
as
    on update to "ForestResources"."ResourceTypes"
    do instead
        update "ForestResources"."ResourceTypesTable"
            set
                "Name" = new."Name"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name"
;
