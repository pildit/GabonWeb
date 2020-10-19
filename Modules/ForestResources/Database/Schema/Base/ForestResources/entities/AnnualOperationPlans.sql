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
