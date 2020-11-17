insert into "ForestResources"."ResourceTypes"
    ("Name")
values
    ('Concession')
    , ('Development Unit')
    , ('Management Unit')
    , ('Annual Allowable Cut')
    , ('Parcel')
on conflict do nothing
;

insert into "ForestResources"."PermitTypes"
    (
        "Name"
        , "Abbreviation"
    )
values
    ('PFA', 'PFA')
    , ('PI', 'PI')
    , ('PTE', 'PTE')
    , ('EXT', 'EXT')
on conflict do nothing
;


insert into "ForestResources"."InventoryQualities" ("Id", "Description", "Value", "CreatedAt") values (1, 1, 1, now());
insert into "ForestResources"."InventoryQualities" ("Id", "Description", "Value", "CreatedAt") values (3, 3, 3, now());
insert into "ForestResources"."InventoryQualities" ("Id", "Description", "Value", "CreatedAt") values (2, 2, 2, now());
insert into "ForestResources"."InventoryQualities" ("Id", "Description", "Value", "CreatedAt") values (4, 4, 4, now());
