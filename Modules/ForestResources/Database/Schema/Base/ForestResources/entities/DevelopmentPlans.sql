create table "ForestResources"."DevelopmentPlansTable"
(
    "Id" int not null,
    "DevelopmentUnit" int not null,
    "Species" int not null,
    "MinimumExploitableDiameter" decimal(8,3) not null,
    "VolumeTariff" text null,
    "Increment" numeric(8,2) null,
    constraint "PK_DevelopmentPlansTable" primary key("Id"),
    constraint "CHK_DevelopmentPlansTable_MinimumExploitableDiameter" check ("MinimumExploitableDiameter" >= 0),
    constraint "UNIQ_DevelopmentPlansTable_DevelopmentUnit_Species" unique ("DevelopmentUnit", "Species"),
    constraint "CHK_DevelopmentPlansTable_VolumeTariff" check ("VolumeTariff" is null or length("VolumeTariff") > 0),
    constraint "CHK_DevelopmentPlanstable_Increment" check("Increment" is null or "Increment" >= 0.0)
)
;

comment on table "ForestResources"."DevelopmentPlansTable"
    is 'Plan pour Unite Forestiere d''Amenagement';

create sequence if not exists "ForestResources"."SEQ_DevelopmentPlans"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."DevelopmentPlansTable"."Id"
;

create unique index "UX_DevelopmentPlansTable.DevelopmentUnit_Species"
on "ForestResources"."DevelopmentPlansTable"
    (
        "DevelopmentUnit"
        , "Species"
    )
;

create index "UX_DevelopmentPlansTable.DevelopmentUnit"
on "ForestResources"."DevelopmentPlansTable"
    (
        "DevelopmentUnit"
    )
;

