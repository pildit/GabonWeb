---------------------------------------
-- "ForestResources"."ResourceTypes" --
---------------------------------------
create table "ForestResources"."ResourceTypesTable"
(
    "Id" int not null,
    "Name" text not null,
    constraint "PK_ResourceTypesTable" primary key ("Id"),
    constraint "CHK_ResourceTypesTable.Name" check (length("Name") > 0),
    constraint "UNIQ_ResourceTypesTable.Name" unique ("Name")
);

create sequence if not exists "ForestResources"."SEQ_ResourceTypes"
    as int
    minvalue 0
    start with 0
    no cycle
    owned by "ForestResources"."ResourceTypesTable"."Id"
;

create unique index "UX_ResourceTypesTable.Name"
on "ForestResources"."ResourceTypesTable"
    (
        "Name"
    )
;
