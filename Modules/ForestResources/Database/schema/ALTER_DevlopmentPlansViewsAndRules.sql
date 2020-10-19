----------
-- VIEW --
----------
create or replace view "ForestResources"."DevelopmentPlans"
as
    select
        dpt."Id"
        , dpt."DevelopmentUnit"
        , dpt."Species"
        , dpt."MinimumExploitableDiameter"
        , dpt."VolumeTariff"
        , dpt."Increment"
        , dpt."CreatedAt"
        , dpt."UpdatedAt"
        , dpt."DeletedAt"
    from "ForestResources"."DevelopmentPlansTable" as dpt
;

-----------
-- RULES --
-----------
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
                , "CreatedAt"
                , "UpdatedAt"
            )
        values
            (
                nextval('"ForestResources"."SEQ_DevelopmentPlans"')
                , new."DevelopmentUnit"
                , new."Species"
                , new."MinimumExploitableDiameter"
                , new."VolumeTariff"
                , new."Increment"
                , new."CreatedAt"
                , new."UpdatedAt"
            )
        returning
            "Id"
            , "DevelopmentUnit"
            , "Species"
            , "MinimumExploitableDiameter"
            , "VolumeTariff"
            , "Increment"
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
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
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "DevelopmentUnit"
                , "Species"
                , "MinimumExploitableDiameter"
                , "VolumeTariff"
                , "Increment"
                , "CreatedAt"
                , "UpdatedAt"
                , "DeletedAt"
;
