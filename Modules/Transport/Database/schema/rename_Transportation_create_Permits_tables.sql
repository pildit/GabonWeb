-- alter schema transportation rename to "Transportation";

create table "Transportation"."PermitsTable"
(
    "Id"                      serial not null
        primary key,
    "Recdate"                 timestamp default now(),
    "Obsdate"                 date,
    "Appuser"                 varchar,
    "Lat"                 real,
    "Lon"                     real,
    "GpsAccu"                integer,
    "PermitNo"               varchar,
    "HarvestName"            varchar,
    "ClientName"             varchar,
    "ConcessionName"         varchar,
    "TransportComp"          varchar,
    "LicensePlate"           varchar,
    "Destination"             varchar,
    "ManagementUnit"         varchar,
    "OperationalUnit"        varchar,
    "AnnualOperationalUnit" varchar,
    "Note"                    varchar,
    "TheGeom"                geometry,
    "PoductType"            varchar,
    "PermitStatus"           varchar,
    "VerifiedBy"             varchar,
    "TransportBy"            varchar,
    "GeneratedBy"            varchar,
    "ScanLat"                real,
    "ScanLon"                real,
    "ScanGpsAccu"           integer,
    "Photos"                  varchar,
    "Farmer"                  varchar,
    "FirstProvince"          varchar,
    "MobileId"               varchar,
    "CreatedAt" timestamp default current_timestamp not null,
    "UpdatedAt" timestamp default current_timestamp not null,
    "DeletedAt" timestamp
);


-- SEQ
create sequence if not exists "Transportation"."SEQ_PermitsTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "Transportation"."PermitsTable"."Id"
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "Transportation"."PermitsTable"
    for each row execute procedure update_timestamp();


create table "Transportation"."PermitItemsTable"
(
    "Id"           serial not null
        primary key,
    "Permit"    bigint,
    "TrunkNumber" varchar,
    "LotNumber"   varchar,
    "Species"      varchar,
    "Diam1"        varchar,
    "Diam2"        varchar,
    "DiamAvg"     varchar,
    "Length"       varchar,
    "Volume"       varchar,
    "Width"        varchar,
    "Height"       varchar,
    "MobileId"    varchar,
    "Appuser"      varchar,
    "CreatedAt" timestamp default current_timestamp not null,
    "UpdatedAt" timestamp default current_timestamp not null,
    "DeletedAt" timestamp
);

-- Foregin Keys
alter table "Transportation"."PermitItemsTable"
    add constraint "FK_LogbookTable_Logbook"
        foreign key
            (
             "Permit"
                )
            references "Transportation"."PermitsTable"("Id")
;


-- SEQ
create sequence if not exists "Transportation"."SEQ_PermitItemsTable"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "Transportation"."PermitItemsTable"."Id"
;

-- update_timestamp function
create or replace function update_timestamp()
    returns trigger as $$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp before insert or update on "Transportation"."PermitItemsTable"
    for each row execute procedure update_timestamp();
