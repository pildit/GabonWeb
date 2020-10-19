create table "ForestResources"."AnnualOperationPlansTable"
(
    "Id" int not null,
    "AnnualAllowableCut" int not null,
    "Species" int not null,
    "ExploitableVolume" decimal(8, 3) not null,
    "NonExploitableVolume" decimal(8, 3) not null,
    "VolumePerHectare" decimal(8, 3) not null,
    "AverageVolume" decimal(8, 3) not null,
    "TotalVolume" decimal(8, 3) not null generated always as ("ExploitableVolume" + "NonExploitableVolume") stored,
    constraint "PK_AnnualOperationPlansTable" primary key("Id"),
    constraint "CHK_AnnualOperationPlansTable_ExploitableVolume" check ("ExploitableVolume" >= 0),
    constraint "CHK_AnnualOperationPlansTable_NonExploitableVolume" check ("NonExploitableVolume" >= 0),
    constraint "CHK_AnnualOperationPlansTable_VolumePerHectare" check ("VolumePerHectare" >= 0),
    constraint "CHK_AnnualOperationPlansTable_AverageVolume" check ("AverageVolume" >= 0),
    constraint "UNIQ_AnnualOperationPlansTable_AnnualAllowableCut_Species" unique ("AnnualAllowableCut", "Species")
)
;

comment on table "ForestResources"."AnnualOperationPlansTable"
    is 'Plan Annuel d''Operations (PAO)';

create sequence if not exists "ForestResources"."SEQ_AnnualOperationPlans"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."AnnualOperationPlansTable"."Id"
;

create unique index "UX_AnnualOperationPlansTable.AnnualAllowableCut_Species"
on "ForestResources"."AnnualOperationPlansTable"
    (
        "AnnualAllowableCut"
        , "Species"
    )
    include
    (
        "ExploitableVolume"
        , "NonExploitableVolume"
        , "TotalVolume"
    )
;

create index "IX_AnnualOperationPlansTable.AnnualAllowableCut"
on "ForestResources"."AnnualOperationPlansTable"
    (
        "AnnualAllowableCut"
    )
    include
    (
        "ExploitableVolume"
        , "NonExploitableVolume"
        , "TotalVolume"
    )
;


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
