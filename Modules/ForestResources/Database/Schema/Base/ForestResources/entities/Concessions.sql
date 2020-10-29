-------------------------------------
-- "ForestResources"."Concessions" --
-------------------------------------
create table "ForestResources"."ConcessionsTable"
(
    "Continent" text not null,
    "Company" int not null,
    "ConstituentPermit" int not null,
    constraint "CHK_ConcessionsTable.Continent" check (length("Continent") > 0),
    constraint "PK_ConcessionsTable" primary key("Id"),
    constraint "UNIQ_ConcessionsTable_ConstituentPermit" unique ("ConstituentPermit")
)
inherits ("ForestResources"."BaseResourcesTable")
;

comment on table "ForestResources"."ConcessionsTable"
    is 'Concessions';

-- If you query by name, you are likely to filter by continent as well, not just name
create index "IX_ConcessionsTable.Name_Continent"
on "ForestResources"."ConcessionsTable"
    (
        "Name"
        , "Continent"
    )
;

create index "IX_ConcessionsTable.Continent"
on "ForestResources"."ConcessionsTable"
    (
        "Continent"
    )
;

create index "IX_ConcessionsTable.ConstituentPermit"
on "ForestResources"."ConcessionsTable"
    (
        "ConstituentPermit"
    )
;

create index "IX_ConcessionsTable.Company"
on "ForestResources"."ConcessionsTable"
    (
        "Company"
    )
;
