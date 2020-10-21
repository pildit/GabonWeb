----------
-- VIEW --
----------
create view "ForestResources"."ManagementPlans"
as
    select
        mpt."Id"
        , mpt."ManagementUnit"
        , mpt."Species"
        , mpt."GrossVolumeUFG"
        , mpt."GrossVolumeYear"
        , mpt."YieldVolumeYear"
        , mpt."CommercialVolumeYear"
    from "ForestResources"."ManagementPlansTable" as mpt
;

comment on view "ForestResources"."ManagementPlans"
    is 'Plan pour Unite Forestiere de Gestion';

-----------
-- RULES --
-----------
create or replace rule "ManagementPlans_instead_of_delete"
as
    on delete to "ForestResources"."ManagementPlans"
    do instead
        delete from "ForestResources"."ManagementPlansTable"
        where
            "ForestResources"."ManagementPlansTable"."Id" = old."Id"
;

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
            )
        returning
            "Id"
            , "ManagementUnit"
            , "Species"
            , "GrossVolumeUFG"
            , "GrossVolumeYear"
            , "YieldVolumeYear"
            , "CommercialVolumeYear"
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
;
