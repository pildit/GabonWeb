----------
-- VIEW --
----------
create view "ForestResources"."DevelopmentPlans"
as
    select
        dpt."Id"
        , dpt."DevelopmentUnit"
        , dpt."Species"
        , dpt."MinimumExploitableDiameter"
        , dpt."VolumeTariff"
        , dpt."Increment"
    from "ForestResources"."DevelopmentPlansTable" as dpt
;

comment on view "ForestResources"."DevelopmentPlans"
    is 'Plan pour Unite Forestiere d''Amenagement';

-----------
-- RULES --
-----------
create or replace rule "DevelopmentPlans_instead_of_delete"
as
    on delete to "ForestResources"."DevelopmentPlans"
    do instead
        delete from "ForestResources"."DevelopmentPlansTable"
        where
            "ForestResources"."DevelopmentPlansTable"."Id" = old."Id"
;

create or replace rule "DevelopmentPlans_instead_of_insert"
as
    on insert to "ForestResources"."DevelopmentPlans"
    do instead
        insert into "ForestResources"."DevelopmentPlansTable"
            (
                "Id"
                , "DevelopmentUnit"
                , "Species"
                , "MinimumExploitableDiameter"
                , "VolumeTariff"
                , "Increment"
            )
        values
            (
                nextval('"ForestResources"."SEQ_DevelopmentPlans"')
                , new."DevelopmentUnit"
                , new."Species"
                , new."MinimumExploitableDiameter"
                , new."VolumeTariff"
                , new."Increment"
            )
        returning
            "Id"
            , "DevelopmentUnit"
            , "Species"
            , "MinimumExploitableDiameter"
            , "VolumeTariff"
            , "Increment"
;

create or replace rule "DevelopmentPlans_instead_of_update"
as
    on update to "ForestResources"."DevelopmentPlans"
    do instead
        update "ForestResources"."DevelopmentPlansTable"
            set
                "DevelopmentUnit" = new."DevelopmentUnit"
                , "Species" = new."Species"
                , "MinimumExploitableDiameter" = new."MinimumExploitableDiameter"
                , "VolumeTariff" = new."VolumeTariff"
                , "Increment" = new."Increment"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "DevelopmentUnit"
                , "Species"
                , "MinimumExploitableDiameter"
                , "VolumeTariff"
                , "Increment"
;
