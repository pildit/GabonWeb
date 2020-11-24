--
-- Carnet de chantier Items/Rows
--
create table "ForestResources"."SiteLogbookItemsTable"
(
	"Id" int not null,
	"SiteLogbook" int not null,
	"HewingId" int not null,
	"Date" timestamp not null,
	"MaxDiameter" decimal,
	"MinDiameter" decimal,
	"AverageDiameter" decimal,
	"Length" decimal,
	"Volume" decimal,
	"ObserveAt" timestamp not null,
	"CreatedAt" timestamp default current_timestamp not null,
	"UpdatedAt" timestamp default current_timestamp not null,
	"DeletedAt" timestamp,
	constraint "PK_SiteLogbookItemsTable" primary key ("Id")
);

--
-- Foreign Keys
--
alter table "ForestResources"."SiteLogbookItemsTable"
add constraint "FK_SiteLogbookItemsTable_SiteLogbook"
    foreign key
        (
            "SiteLogbook"
        )
    references "ForestResources"."SiteLogbooksTable"("Id")
;

--
-- SEQ
--
create sequence if not exists "ForestResources"."SEQ_SiteLogbookItemsTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."SiteLogbookItemsTable"."Id"
;

--
-- View
--
create or replace view "ForestResources"."SiteLogbookItems"
as
    select
        slbi."Id",
        slbi."SiteLogbook",
        slbi."HewingId",
        slbi."Date",
        slbi."MaxDiameter",
        slbi."MinDiameter",
        slbi."AverageDiameter",
        slbi."Length",
        slbi."Volume",
        slbi."ObserveAt",
        slbi."CreatedAt",
        slbi."UpdatedAt",
        slbi."DeletedAt"
    from "ForestResources"."SiteLogbookItemsTable" as slbi
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "ForestResources"."SiteLogbookItemsTable"
    for each row execute procedure update_timestamp();

--
-- Rules
--
create or replace rule "SiteLogbookItems_instead_of_delete"
as
    on delete to "ForestResources"."SiteLogbookItems"
    do instead
        delete from "ForestResources"."SiteLogbookItemsTable"
        where
            "ForestResources"."SiteLogbookItemsTable"."Id" = old."Id"
;

create or replace rule "SiteLogbookItems_instead_of_insert"
as
    on insert to "ForestResources"."SiteLogbookItems"
    do instead
        insert into "ForestResources"."SiteLogbookItemsTable"
        (
            "Id",
            "SiteLogbook",
            "HewingId",
            "Date",
            "MaxDiameter",
            "MinDiameter",
            "AverageDiameter",
            "Length",
            "Volume",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt"
        )
        values
        (
            nextval('"ForestResources"."SEQ_SiteLogbookItemsTable"'),
            new."SiteLogbook",
            new."HewingId",
            new."Date",
            new."MaxDiameter",
            new."MinDiameter",
            new."AverageDiameter",
            new."Length",
            new."Volume",
            new."ObserveAt",
            new."CreatedAt",
            new."UpdatedAt"
        )
        returning
            "Id",
            "SiteLogbook",
            "HewingId",
            "Date",
            "MaxDiameter",
            "MinDiameter",
            "AverageDiameter",
            "Length",
            "Volume",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "SiteLogbookItems_instead_of_update"
as
    on update to "ForestResources"."SiteLogbookItems"
    do instead
        update "ForestResources"."SiteLogbookItemsTable"
        set
            "HewingId" = new."HewingId",
            "Date" = new."Date",
            "MaxDiameter" = new."MaxDiameter",
            "MinDiameter" = new."MinDiameter",
            "AverageDiameter" = new."AverageDiameter",
            "Length" = new."Length",
            "Volume" = new."Volume",
            "ObserveAt" = new."ObserveAt",
            "UpdatedAt" = new."UpdatedAt",
            "DeletedAt" = new."DeletedAt"
        where
            "SiteLogbookItemsTable"."Id" = old."Id"
        returning
            "Id",
            "SiteLogbook",
            "HewingId",
            "Date",
            "MaxDiameter",
            "MinDiameter",
            "AverageDiameter",
            "Length",
            "Volume",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;
