create table "ForestResources"."SiteLogbookLogsTable"
(
	"Id" int not null,
	"SiteLogbookItem" int not null,
	"HewingId" varchar,
	"Species" int not null,
	"MaxDiameter" decimal,
	"MinDiameter" decimal,
	"AverageDiameter" decimal,
	"Length" decimal,
	"Volume" decimal,
	"Note" text,
	"EvacuationDate" timestamp,
	"Lat" varchar not null,
	"Lon" varchar not null,
	"GPSAccuracy" decimal default 0,
	"ObserveAt" timestamp not null,
	"CreatedAt" timestamp default CURRENT_TIMESTAMP not null,
	"UpdatedAt" timestamp default CURRENT_TIMESTAMP not null,
	"DeletedAt" timestamp
);
--
-- Foreign Keys
--
alter table "ForestResources"."SiteLogbookLogsTable"
add constraint "FK_SiteLogbookLogsTable_SiteLogbookItem"
    foreign key
        (
            "SiteLogbookItem"
        )
    references "ForestResources"."SiteLogbookItemsTable"("Id")
;

--
-- SEQ
--
create sequence if not exists "ForestResources"."SEQ_SiteLogbookLogsTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."SiteLogbookLogsTable"."Id"
;

--
-- View
--

create or replace view "ForestResources"."SiteLogbookLogs"
as
    select
        slbl."Id",
        slbl."SiteLogbookItem",
        slbl."HewingId",
        slbl."Species",
        slbl."MaxDiameter",
        slbl."MinDiameter",
        slbl."AverageDiameter",
        slbl."Length",
        slbl."Volume",
        slbl."Note",
        slbl."EvacuationDate",
        slbl."Lat",
        slbl."Lon",
        slbl."GPSAccuracy",
        slbl."ObserveAt",
        slbl."CreatedAt",
        slbl."UpdatedAt",
        slbl."DeletedAt"
    from "ForestResources"."SiteLogbookLogsTable" as slbl
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "ForestResources"."SiteLogbookLogsTable"
    for each row execute procedure update_timestamp();

--
-- Rules
--
create or replace rule "SiteLogbookLogs_instead_of_delete"
as
    on delete to "ForestResources"."SiteLogbookLogs"
    do instead
        delete from "ForestResources"."SiteLogbookLogsTable"
        where
            "ForestResources"."SiteLogbookLogsTable"."Id" = old."Id"
;

create or replace rule "SiteLogbookLogs_instead_of_insert"
as
    on insert to "ForestResources"."SiteLogbookLogs"
    do instead
        insert into "ForestResources"."SiteLogbookLogsTable"
        (
            "Id",
            "SiteLogbookItem",
            "HewingId",
            "Species",
            "MaxDiameter",
            "MinDiameter",
            "AverageDiameter",
            "Length",
            "Volume",
            "Note",
            "EvacuationDate",
            "Lat",
            "Lon",
            "GPSAccuracy",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt"
        )
        values
        (
            nextval('"ForestResources"."SEQ_SiteLogbookLogsTable"'),
            new."SiteLogbookItem",
            new."HewingId",
            new."Species",
            new."MaxDiameter",
            new."MinDiameter",
            new."AverageDiameter",
            new."Length",
            new."Volume",
            new."Note",
            new."EvacuationDate",
            new."Lat",
            new."Lon",
            new."GPSAccuracy",
            new."ObserveAt",
            new."CreatedAt",
            new."UpdatedAt"
        )
        returning
            "Id",
            "SiteLogbookItem",
            "HewingId",
            "Species",
            "MaxDiameter",
            "MinDiameter",
            "AverageDiameter",
            "Length",
            "Volume",
            "Note",
            "EvacuationDate",
            "Lat",
            "Lon",
            "GPSAccuracy",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;

create or replace rule "SiteLogbookLogs_instead_of_update"
as
    on update to "ForestResources"."SiteLogbookLogs"
    do instead
        update "ForestResources"."SiteLogbookLogsTable"
        set
            "SiteLogbookItem" = new."SiteLogbookItem",
            "HewingId" = new."HewingId",
            "Species" = new."Species",
            "MaxDiameter" = new."MaxDiameter",
            "MinDiameter" = new."MinDiameter",
            "AverageDiameter" = new."AverageDiameter",
            "Length" = new."Length",
            "Volume" = new."Volume",
            "Note" = new."Note",
            "EvacuationDate" = new."EvacuationDate",
            "Lat" = new."Lat",
            "Lon" = new."Lon",
            "GPSAccuracy" = new."GPSAccuracy",
            "ObserveAt" = new."ObserveAt",
            "UpdatedAt" = new."UpdatedAt",
            "DeletedAt" = new."DeletedAt"
        where
            old."Id" = new."Id"
        returning
            "Id",
            "SiteLogbookItem",
            "HewingId",
            "Species",
            "MaxDiameter",
            "MinDiameter",
            "AverageDiameter",
            "Length",
            "Volume",
            "Note",
            "EvacuationDate",
            "Lat",
            "Lon",
            "GPSAccuracy",
            "ObserveAt",
            "CreatedAt",
            "UpdatedAt",
            "DeletedAt"
;
