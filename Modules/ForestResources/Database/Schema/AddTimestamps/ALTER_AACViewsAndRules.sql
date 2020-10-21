-- AnnualAllowableCuts
create or replace view "ForestResources"."AnnualAllowableCuts"
as
    select
        mut."Id"
        , mut."Name"
        , mut."ManagementUnit"
        , mut."Geometry"
        , mut."CreatedAt"
        , mut."UpdatedAt"
        , mut."DeletedAt"
    from "ForestResources"."AnnualAllowableCutsTable" as mut
;

create or replace rule "AnnualAllowableCuts_instead_of_insert"
as
    on insert to "ForestResources"."AnnualAllowableCuts"
    do instead
        insert into "ForestResources"."AnnualAllowableCutsTable"
            ("Id","ResourceType", "Name", "ManagementUnit","Geometry", "CreatedAt", "UpdatedAt")
        values
            (
                nextval('"ForestResources"."SEQ_BaseResources"')
                ,(
                    select rt."Id"
                    from "ForestResources"."ResourceTypes" as rt
                    where rt."Name" = 'Annual Allowable Cut'
                    limit 1)
                , new."Name"
                , new."ManagementUnit"
                , new."Geometry"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id",
            "Name",
            "ManagementUnit",
            "Geometry",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "AnnualAllowableCuts_instead_of_update"
as
    on update to "ForestResources"."AnnualAllowableCuts"
    do instead
        update "ForestResources"."AnnualAllowableCutsTable"
            set
                "Name" = new."Name"
                , "ManagementUnit" = new."ManagementUnit"
                , "Geometry" = new."Geometry"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id",
                "Name",
                "ManagementUnit",
                "Geometry",
                "CreatedAt",
                "UpdatedAt",
                "DeletedAt"
;
