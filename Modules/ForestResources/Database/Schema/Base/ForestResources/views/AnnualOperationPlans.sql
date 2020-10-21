----------
-- VIEW --
----------
create view "ForestResources"."AnnualOperationPlans"
as
    select
        aopt."Id"
        , aopt."AnnualAllowableCut"
        , aopt."Species"
        , aopt."ExploitableVolume"
        , aopt."NonExploitableVolume"
        , aopt."VolumePerHectare"
        , aopt."AverageVolume"
        , aopt."TotalVolume"
    from "ForestResources"."AnnualOperationPlansTable" as aopt
;

comment on view "ForestResources"."AnnualOperationPlans"
    is 'Plan Annuel d''Operations (PAO)';

-----------
-- RULES --
-----------
create or replace rule "AnnualOperationPlans_instead_of_delete"
as
    on delete to "ForestResources"."AnnualOperationPlans"
    do instead
        delete from "ForestResources"."AnnualOperationPlansTable"
        where
            "ForestResources"."AnnualOperationPlansTable"."Id" = old."Id"
;

create or replace rule "AnnualOperationPlans_instead_of_insert"
as
    on insert to "ForestResources"."AnnualOperationPlans"
    do instead
        insert into "ForestResources"."AnnualOperationPlansTable"
            (
                "Id"
                , "AnnualAllowableCut"
                , "Species"
                , "ExploitableVolume"
                , "NonExploitableVolume"
                , "VolumePerHectare"
                , "AverageVolume"
            )
        values
            (
                nextval('"ForestResources"."SEQ_AnnualOperationPlans"')
                , new."AnnualAllowableCut"
                , new."Species"
                , new."ExploitableVolume"
                , new."NonExploitableVolume"
                , new."VolumePerHectare"
                , new."AverageVolume"
            )
        returning
            "Id"
            , "AnnualAllowableCut"
            , "Species"
            , "ExploitableVolume"
            , "NonExploitableVolume"
            , "VolumePerHectare"
            , "AverageVolume"
            , "TotalVolume"
;

create or replace rule "AnnualOperationPlans_instead_of_update"
as
    on update to "ForestResources"."AnnualOperationPlans"
    do instead
        update "ForestResources"."AnnualOperationPlansTable"
            set
                "AnnualAllowableCut" = new."AnnualAllowableCut"
                , "Species" = new."Species"
                , "ExploitableVolume" = new."ExploitableVolume"
                , "NonExploitableVolume" = new."NonExploitableVolume"
                , "VolumePerHectare" = new."VolumePerHectare"
                , "AverageVolume" = new."AverageVolume"
            where
                "Id" = old."Id"
            returning
                "Id"
                , "AnnualAllowableCut"
                , "Species"
                , "ExploitableVolume"
                , "NonExploitableVolume"
                , "VolumePerHectare"
                , "AverageVolume"
                , "TotalVolume"
;
