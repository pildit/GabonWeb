create table transportation."PermitTrackingTable"
(
    "Id" serial,
    "User" int not null,
    "Permit" int not null,
    "Lat" varchar not null,
    "Lon" varchar not null,
    "GPSAccuracy" decimal(8, 3),
    "Geometry" public.geometry not null,
    "ObserveAt" timestamp not null,
    "CreatedAt" timestamp default CURRENT_TIMESTAMP,
    "UpdatedAt" timestamp default CURRENT_TIMESTAMP
);

create view "transportation"."PermitTracking"
as
select
    pt."Id",
    pt."User",
    pt."Permit",
    pt."Lat",
    pt."Lon",
    pt."GPSAccuracy",
    pt."Geometry",
    pt."ObserveAt",
    pt."CreatedAt",
    pt."UpdatedAt"
from "transportation"."PermitTrackingTable" pt;


create or replace rule "PermitTracking_instead_of_delete"
as
    on delete to "transportation"."PermitTracking"
    do instead
        delete from "transportation"."PermitTrackingTable"
    where
        "transportation"."PermitTrackingTable"."Id" = old."Id";

create or replace rule "PermitTracking_instead_of_insert"
as
    on insert to "transportation"."PermitTracking"
    do instead
    insert into "transportation"."PermitTrackingTable"
        ("Id", "User", "Permit", "Lat", "Lon", "GPSAccuracy", "Geometry", "ObserveAt", "CreatedAt", "UpdatedAt")
    values
    (
        nextval('"transportation"."PermitTrackingTable_Id_seq"'),
        new."User",
        new."Permit",
        new."Lat",
        new."Lon",
        new."GPSAccuracy",
        new."Geometry",
        new."ObserveAt",
        new."CreatedAt",
        new."UpdatedAt"
    )
    returning
        "Id",
        "User",
        "Permit",
        "Lat",
        "Lon",
        "GPSAccuracy",
        "Geometry",
        "ObserveAt",
        "CreatedAt",
        "UpdatedAt"
;

create or replace rule "PermitTracking_instead_of_update"
as
    on update to "transportation"."PermitTracking"
    do instead
        update "transportation"."PermitTrackingTable"
    set
        "User" = new."User",
        "Lat" = new."Lat",
        "Lon" = new."Lon",
        "GPSAccuracy" = new."GPSAccuracy",
        "Geometry" = new."Geometry",
        "ObserveAt" = new."ObserveAt",
        "UpdatedAt" = new."UpdatedAt"
    where
            "Id" = old."Id"
    returning
        "Id",
        "User",
        "Permit",
        "Lat",
        "Lon",
        "GPSAccuracy",
        "Geometry",
        "ObserveAt",
        "CreatedAt",
        "UpdatedAt"
;
