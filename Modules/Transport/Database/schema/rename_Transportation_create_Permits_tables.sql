alter schema "transportation" rename to "Transportation";

create table "Transportation"."PermitsTable"
(
    "Id"                    serial                              not null
        primary key,

    "PermitNo"              varchar,
    "PermitNoMobile"        varchar,
    "Concession"            integer, -- cheie straina concession
    "ManagementUnit"        integer, -- cheie straina catre managementunit - UFG
    "DevelopmentUnit"       integer, -- cheie straina - UFA
    "AnnualAllowableCut"    integer, -- HarvestName ?  - cheie straina aac
    "ClientCompany"         integer, -- companies - type client - cheie straina
    "ConcessionaireCompany" integer, -- companies - type client - cheie straina
    "TransporterCompany"    integer, -- companies - type transporter - cheie straina
    "User"                  integer, -- cheie straina user
    "ProductType"           integer default '1', -- ResourceType
    "Status"                integer, -- o lista de statusuri
    "DriverName"            varchar,
    "LicensePlate"          varchar,
    "Province"              varchar,
    "Destination"           varchar,
    "ScanLat"               real,
    "ScanLon"               real,
    "ScanGpsAccu"           integer,
    "Lat"                   real,
    "Lon"                   real,
    "GpsAccu"               integer,
    "Geometry"              geometry,
    "MobileId"              varchar, -- la parinte mobileId este egal PermitNoMobile
    "ObserveAt"             date,
    "CreatedAt"             timestamp default current_timestamp not null,
    "UpdatedAt"             timestamp default current_timestamp not null,
    "DeletedAt"             timestamp
);

-- Foregin Keys
alter table "Transportation"."PermitsTable"
    add constraint "FK_ConcessionsTable_Concession"
        foreign key
            (
             "Concession"
                )
            references "ForestResources"."ConcessionsTable" ("Id")
;

alter table "Transportation"."PermitsTable"
    add constraint "FK_ManagementUnitsTable_ManagementUnit"
        foreign key
            (
             "ManagementUnit"
                )
            references "ForestResources"."ManagementUnitsTable" ("Id")
;

alter table "Transportation"."PermitsTable"
    add constraint "FK_DevelopmentUnitsTable_DevelopmentUnit"
        foreign key
            (
             "DevelopmentUnit"
                )
            references "ForestResources"."DevelopmentUnitsTable" ("Id")
;

alter table "Transportation"."PermitsTable"
    add constraint "FK_AnnualAllowableCutsTable_AnnualAllowableCut"
        foreign key
            (
             "AnnualAllowableCut"
                )
            references "ForestResources"."AnnualAllowableCutsTable" ("Id")
;

alter table "Transportation"."PermitsTable"
    add constraint "FK_CompaniesTableTable_ClientCompany"
        foreign key
            (
             "ClientCompany"
                )
            references "Taxonomy"."CompaniesTable" ("Id")
;


alter table "Transportation"."PermitsTable"
    add constraint "FK_CompaniesTableTable_ConcessionaireCompany"
        foreign key
            (
             "ConcessionaireCompany"
                )
            references "Taxonomy"."CompaniesTable" ("Id")
;


alter table "Transportation"."PermitsTable"
    add constraint "FK_CompaniesTableTable_TransporterCompany"
        foreign key
            (
             "TransporterCompany"
                )
            references "Taxonomy"."CompaniesTable" ("Id")
;
alter table "Transportation"."PermitsTable"
    add constraint "FK_accountsTable_User"
        foreign key
            (
             "User"
                )
            references "admin"."accounts" ("id")
;

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
    returns trigger as
$$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp
    before insert or update
    on "Transportation"."PermitsTable"
    for each row
execute procedure update_timestamp();


create table "Transportation"."PermitItemsTable"
(
    "Id"              serial                              not null
        primary key,
    "Permit"          bigint,
    "TreeId"          text,    -- Log id  -- autosugestul mai trebuie discutat ca e in offline nu putem face endpoint. ( cea a concesiunii companiei la care lucreaza userul )
    "Species"         integer, -- cheie straina
    "MinDiameter"     float,
    "MaxDiameter"     float,
    "AverageDiameter" float,
    "Length"          float,
    "Volume"          float,
    "MobileId"        varchar,
    "CreatedAt"       timestamp default current_timestamp not null,
    "UpdatedAt"       timestamp default current_timestamp not null,
    "DeletedAt"       timestamp
);

-- Foregin Keys
alter table "Transportation"."PermitItemsTable"
    add constraint "FK_PermitsTable_Permit"
        foreign key
            (
             "Permit"
                )
            references "Transportation"."PermitsTable" ("Id")
;

alter table "Transportation"."PermitItemsTable"
    add constraint "FK_SpeciesTable_Species"
        foreign key
            (
             "Species"
                )
            references "Taxonomy"."SpeciesTable" ("Id")
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
    returns trigger as
$$
begin
    new."UpdatedAt" = now();
    return new;
end ;
$$ language 'plpgsql';

create trigger user_timestamp
    before insert or update
    on "Transportation"."PermitItemsTable"
    for each row
execute procedure update_timestamp();
