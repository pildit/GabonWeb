create table "ForestResources"."LogbookItemsTable"
(
    "Id" int not null,
    "Logbook" int not null,
    "AnnualAllowableCutInventory" int not null,
    "HewingId" int,
    "Species" int not null,
    "MaxDiameter" decimal,
    "MinDiameter" decimal,
    "Length" decimal,
    "Volume" decimal,
    "Note" text,
    "ObserveAt" timestamp not null,
    "CreatedAt" timestamp default current_timestamp not null,
    "UpdatedAt" timestamp default current_timestamp not null,
    "DeletedAt" timestamp
);

-- Foregin Keys
alter table "ForestResources"."LogbookItemsTable"
    add constraint "FK_LogbookTable_Logbook"
        foreign key
            (
             "Logbook"
                )
            references "ForestResources"."LogbooksTable"("Id")
;

alter table "ForestResources"."LogbookItemsTable"
    add constraint "FK_LogbookItemsTable_AnnualAllowableCutInventory"
        foreign key
            (
             "AnnualAllowableCutInventory"
                )
            references "ForestResources"."AnnualAllowableCutInventoryTable"("Id")
;

alter table "ForestResources"."LogbookItemsTable"
    add constraint "FK_LogbookItemsTable_Species"
        foreign key
            (
             "Species"
                )
            references "Taxonomy"."SpeciesTable"("Id")
;

-- SEQ
create sequence if not exists "ForestResources"."SEQ_LogbookItemsTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."LogbookItemsTable"."Id"
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "ForestResources"."LogbookItemsTable"
    for each row execute procedure update_timestamp();

-- View
create or replace view "ForestResources"."LogbookItems"
as
select
    lbi."Id",
    lbi."Logbook",
    lbi."AnnualAllowableCutInventory",
    lbi."HewingId",
    lbi."Species",
    lbi."MaxDiameter",
    lbi."MinDiameter",
    lbi."Length",
    lbi."Volume",
    lbi."Note",
    lbi."ObserveAt",
    lbi."CreatedAt",
    lbi."UpdatedAt",
    lbi."DeletedAt"
from "ForestResources"."LogbookItemsTable" as lbi
;

-- Rules
create or replace rule "LogbookItems_instead_of_delete"
    as
    on delete to "ForestResources"."LogbookItems"
    do instead
    delete from "ForestResources"."LogbookItemsTable"
    where
            "ForestResources"."LogbookItemsTable"."Id" = old."Id"
;

create or replace rule "LogbookItems_instead_of_insert"
    as
    on insert to "ForestResources"."LogbookItems"
    do instead
    insert into "ForestResources"."LogbookItemsTable"
    (
        "Id",
        "Logbook",
        "AnnualAllowableCutInventory",
        "HewingId",
        "Species",
        "MaxDiameter",
        "MinDiameter",
        "Length",
        "Volume",
        "Note",
        "ObserveAt",
        "CreatedAt",
        "UpdatedAt",
        "DeletedAt"
    )
    values
    (
        nextval('"ForestResources"."SEQ_LogbookItemsTable"'),
        new."Logbook",
        new."AnnualAllowableCutInventory",
        new."HewingId",
        new."Species",
        new."MaxDiameter",
        new."MinDiameter",
        new."Length",
        new."Volume",
        new."Note",
        new."ObserveAt",
        new."CreatedAt",
        new."UpdatedAt",
        new."DeletedAt"
    )
    returning
        "Id",
        "Logbook",
        "AnnualAllowableCutInventory",
        "HewingId",
        "Species",
        "MaxDiameter",
        "MinDiameter",
        "Length",
        "Volume",
        "Note",
        "ObserveAt",
        "CreatedAt",
        "UpdatedAt",
        "DeletedAt"
;

create or replace rule "LogbookItems_instead_of_update"
    as
    on update to "ForestResources"."LogbookItems"
    do instead
    update "ForestResources"."LogbookItemsTable"
    set
        "Logbook" = new."Logbook",
        "AnnualAllowableCutInventory" = new."AnnualAllowableCutInventory",
        "HewingId" = new."HewingId",
        "Species" = new."Species",
        "MaxDiameter" = new."MaxDiameter",
        "MinDiameter" = new."MinDiameter",
        "Length" = new."Length",
        "Volume" = new."Volume",
        "Note" = new."Note",
        "ObserveAt" = new."ObserveAt",
        "UpdatedAt" = new."UpdatedAt",
        "DeletedAt" = new."DeletedAt"
    where
            old."Id" = new."Id"
    returning
        "Id",
        "Logbook",
        "AnnualAllowableCutInventory",
        "HewingId",
        "Species",
        "MaxDiameter",
        "MinDiameter",
        "Length",
        "Volume",
        "Note",
        "ObserveAt",
        "CreatedAt",
        "UpdatedAt",
        "DeletedAt"
;
