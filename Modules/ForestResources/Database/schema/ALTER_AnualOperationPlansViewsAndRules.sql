-- AnnualOperationPlans
create or replace view "ForestResources"."AnnualOperationPlans"
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
        , aopt."CreatedAt"
        , aopt."UpdatedAt"
        , aopt."DeletedAt"
    from "ForestResources"."AnnualOperationPlansTable" as aopt
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
                , "CreatedAt"
                , "UpdatedAt"
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
                , new."CreatedAt"
                , new."UpdatedAt"
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
            , "CreatedAt"
            , "UpdatedAt"
            , "DeletedAt"
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
                , "UpdatedAt" = new."UpdatedAt"
                , "DeletedAt" = new."DeletedAt"
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
                , "CreatedAt"
                , "UpdatedAt"
                , "DeletedAt"
;
