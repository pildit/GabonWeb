----------
-- VIEW --
----------
create or replace view "ForestResources"."ManagementPlans"
as
    select
        mpt."Id"
        , mpt."ManagementUnit"
        , mpt."Species"
        , mpt."GrossVolumeUFG"
        , mpt."GrossVolumeYear"
        , mpt."YieldVolumeYear"
        , mpt."CommercialVolumeYear"
        , mpt."CreatedAt"
        , mpt."UpdatedAt"
        , mpt."DeletedAt"
    from "ForestResources"."ManagementPlansTable" as mpt
;

-----------
-- RULES --
-----------
create or replace rule "ManagementPlans_instead_of_insert"
as
    on insert to "ForestResources"."ManagementPlans"
    do instead
        insert into "ForestResources"."ManagementPlansTable"
            (
                "Id"
                , "ManagementUnit"
                , "Species"
                , "GrossVolumeUFG"
                , "GrossVolumeYear"
                , "YieldVolumeYear"
                , "CommercialVolumeYear"
                , "CreatedAt"
                , "UpdatedAt"
            )
        values
            (
                nextval('"ForestResources"."SEQ_ManagementPlans"')
                , new."ManagementUnit"
                , new."Species"
                , new."GrossVolumeUFG"
                , new."GrossVolumeYear"
                , new."YieldVolumeYear"
                , new."CommercialVolumeYear"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id"
            , "ManagementUnit"
            , "Species"
            , "GrossVolumeUFG"
            , "GrossVolumeYear"
            , "YieldVolumeYear"
            , "CommercialVolumeYear"
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
;

create or replace rule "ManagementPlans_instead_of_update"
as
    on update to "ForestResources"."ManagementPlans"
    do instead
        update "ForestResources"."ManagementPlansTable"
            set
                "ManagementUnit" = new."ManagementUnit"
                , "Species" = new."Species"
                , "GrossVolumeUFG" = new."GrossVolumeUFG"
                , "GrossVolumeYear" = new."GrossVolumeYear"
                , "YieldVolumeYear" = new."YieldVolumeYear"
                , "CommercialVolumeYear" = new."CommercialVolumeYear"
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "ManagementUnit"
                , "Species"
                , "GrossVolumeUFG"
                , "GrossVolumeYear"
                , "YieldVolumeYear"
                , "CommercialVolumeYear"
                , "CreatedAt"
                , "UpdatedAt"
                , "DeletedAt"
;
