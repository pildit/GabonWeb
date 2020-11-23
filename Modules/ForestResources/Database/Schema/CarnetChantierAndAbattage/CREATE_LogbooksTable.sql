--
-- Carnet d'abattage
--
create table "ForestResources"."LogbooksTable"
(
    "Id" int not null,
    "Concession" int not null,
    "DevelopmentUnit" int not null,
    "ManagementUnit" int not null,
    "AnnualAllowableCut" int not null,
    "ObserveAt" timestamp,
    "CreatedAt" timestamp default CURRENT_TIMESTAMP not null,
    "UpdatedAt" timestamp default CURRENT_TIMESTAMP not null,
    "DeletedAt" timestamp,
    constraint "PK_LogbooksTable" primary key ("Id")
);
-- Foregin Keys
alter table "ForestResources"."LogbooksTable"
add constraint "FK_LogbooksTable_Concession"
    foreign key
        (
            "Concession"
        )
    references "ForestResources"."ConcessionsTable"("Id")
;

alter table "ForestResources"."LogbooksTable"
add constraint "FK_LogbooksTable_DevelopmentUnit"
    foreign key
        (
            "DevelopmentUnit"
        )
    references "ForestResources"."DevelopmentUnitsTable"("Id")
;

alter table "ForestResources"."LogbooksTable"
add constraint "FK_LogbooksTable_ManagementUnit"
    foreign key
        (
            "ManagementUnit"
        )
    references "ForestResources"."ManagementUnitsTable"("Id")
;

alter table "ForestResources"."LogbooksTable"
add constraint "FK_LogbooksTable_AnnualAllowableCut"
    foreign key
        (
            "AnnualAllowableCut"
        )
    references "ForestResources"."AnnualAllowableCutsTable"("Id")
;

-- SEQ
create sequence if not exists "ForestResources"."SEQ_LogbooksTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."LogbooksTable"."Id"
;

-- View
create or replace view "ForestResources"."Logbooks"
as
    select
        lb."Id",
        lb."Concession",
        lb."DevelopmentUnit",
        lb."ManagementUnit",
        lb."AnnualAllowableCut",
        lb."ObserveAt",
        lb."CreatedAt",
        lb."UpdatedAt",
        lb."DeletedAt"
    from "ForestResources"."LogbooksTable" as lb
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "ForestResources"."LogbooksTable"
    for each row execute procedure update_timestamp();

-- Rules
create or replace rule "Logbooks_instead_of_delete"
as
    on delete to "ForestResources"."Logbooks"
    do instead
        delete from "ForestResources"."LogbooksTable"
        where
            "ForestResources"."LogbooksTable"."Id" = old."Id"
;

create or replace rule "Logbooks_instead_of_insert"
as
    on insert to "ForestResources"."Logbooks"
    do instead
        insert into "ForestResources"."LogbooksTable"
            (
                 "Id",
                 "Concession",
                 "DevelopmentUnit",
                 "ManagementUnit",
                 "AnnualAllowableCut",
                 "ObserveAt",
                 "CreatedAt",
                 "UpdatedAt"
             )
        values
            (
                nextval('"ForestResources"."SEQ_LogbooksTable"'),
                new."Concession",
                new."DevelopmentUnit",
                new."ManagementUnit",
                new."AnnualAllowableCut",
                new."ObserveAt",
                new."CreatedAt",
                new."UpdatedAt"
            )
        returning
            "Id",
            "Concession",
            "DevelopmentUnit",
            "ManagementUnit",
            "AnnualAllowableCut",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "Logbooks_instead_of_update"
as
    on update to "ForestResources"."Logbooks"
    do instead
        update "ForestResources"."LogbooksTable"
            set "Concession" = new."Concession",
                "DevelopmentUnit" = new."DevelopmentUnit",
                "ManagementUnit" = new."ManagementUnit",
                "AnnualAllowableCut" = new."AnnualAllowableCut",
                "UpdatedAt" = new."UpdatedAt",
                "DeletedAt" = new."DeletedAt"
            where
                "LogbooksTable"."Id" = old."Id"
        returning
            "Id",
            "Concession",
            "DevelopmentUnit",
            "ManagementUnit",
            "AnnualAllowableCut",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

