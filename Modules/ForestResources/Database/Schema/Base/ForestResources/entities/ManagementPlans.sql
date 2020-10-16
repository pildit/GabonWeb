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
