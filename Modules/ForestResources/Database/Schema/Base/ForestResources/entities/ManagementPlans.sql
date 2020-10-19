create table "ForestResources"."ManagementPlansTable"
(
    "Id" int not null,
    "ManagementUnit" int not null,
    "Species" int not null,
    "GrossVolumeUFG" numeric not null,
    "GrossVolumeYear" numeric not null,
    "YieldVolumeYear" numeric not null,
    "CommercialVolumeYear" numeric not null,
    constraint "PK_ManagementPlansTable" primary key("Id"),
    constraint "UNIQ_ManagementPlansTable_ManagementUnit_Species" unique ("ManagementUnit", "Species"),
    constraint "CHK_ManagementPlansTable_GrossVolumeUFG" check ("GrossVolumeUFG" >= 0),
    constraint "CHK_ManagementPlansTable_GrossVolumeYear" check ("GrossVolumeYear" >= 0),
    constraint "CHK_ManagementPlansTable_YieldVolumeYear" check ("YieldVolumeYear" >= 0),
    constraint "CHK_ManagementPlansTable_CommercialVolumeYear" check ("CommercialVolumeYear" >= 0)
)
;

comment on table "ForestResources"."ManagementPlansTable"
    is 'Plan pour Unite Forestiere de Gestion';

create sequence if not exists "ForestResources"."SEQ_ManagementPlans"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."ManagementPlansTable"."Id"
;

create unique index "UX_ManagementPlansTable.ManagementUnit_Species"
on "ForestResources"."ManagementPlansTable"
    (
        "ManagementUnit"
        , "Species"
    )
;

create index "UX_ManagementPlansTable.ManagementUnit"
on "ForestResources"."ManagementPlansTable"
    (
        "ManagementUnit"
    )
;
