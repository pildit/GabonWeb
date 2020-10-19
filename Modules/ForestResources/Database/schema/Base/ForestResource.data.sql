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
